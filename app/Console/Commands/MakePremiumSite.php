<?php

namespace App\Console\Commands;

use App\Models\Shop;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\{
    DB,
    File
};
use Laravel\Passport\ClientRepository;

class MakePremiumSite extends Command
{
    /**
     * @var string
     */
    private $parentDir = '/data1/www';

    /**
     * @var string
     */
    private $portalDir = 'www.pattolixil-madohonpo.jp';

    /**
     * @var string
     */
    private $dumpPath = '/db/wordpress/madohonpo.sql';

    /**
     * @var string
     */
    private $wpTemplatePath = '/web/src/wordpress_template';

    /**
     * @var string
     */
    private $sourceDomain = 'wp-test.pattolixil-madohonpo.jp';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:premium_site {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make premium site from wordpress_template';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $domain = $this->argument('domain');

        // 指定されたドメイン名のディレクトリが存在しているかを確認し、
        // 存在していれば処理を打ち切る
        if (File::exists("{$this->parentDir}/{$domain}")) {
            $this->info('Directory named of this domain exists right now.');
            return;
        }

        // 指定したドメインで登録されているshopを取得する
        $shop = Shop::premiumShopDomain($domain)->get();
        if ($shop->isEmpty()) {
            // 指定されたドメインのショップが存在しない場合
            $this->info('This domain is not registered.');
            return;

        } else if ($shop->count() > 1) {
            // 指定されたドメインが複数のショップに登録されている
            $this->info('This domain is registered to multiple shops.');
            return;
        }
        
        // 唯一存在するshopがあるのを確認したため、modelとして再取得
        $shop = $shop->first();

        /**
         * データベース
         */
        // データベースの作成
        $dbName = str_replace('.', '_', $domain);
        $charset = config('database.connections.mysql.charset', 'utf8mb4');
        $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');
        $query = "CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET {$charset} COLLATE {$collation};";
        DB::statement($query);
        $this->info("Created database {$dbName}.");
        
        // dumpの適用
        DB::unprepared("USE `{$dbName}`;" . file_get_contents($this->parentDir . '/' . $this->portalDir . $this->dumpPath));
        $this->info('Applied ' . $this->parentDir . '/' . $this->portalDir . $this->dumpPath . " to {$dbName}.");

        // レコードに含まれるドメインの変更
        // SQL中にAUTOCOMMITを0にセットする記述がある場合に対応し、念のためAUTOCOMMITを1にする
        $updateSql = "SET AUTOCOMMIT = 1;"
        . "UPDATE `wp_posts` SET guid=REPLACE (guid, '{$this->sourceDomain}', '{$domain}');"
        . "UPDATE `wp_posts` SET post_content=REPLACE (post_content, '{$this->sourceDomain}', '{$domain}');"
        . "UPDATE `wp_options` SET option_value=REPLACE (option_value, '{$this->sourceDomain}', '{$domain}');. "
        . "UPDATE `wp_postmeta` SET meta_value=REPLACE (meta_value, '{$this->sourceDomain}', '{$domain}');"
        . "UPDATE `wp_posts` SET post_title=REPLACE (post_title, '{$this->sourceDomain}', '{$domain}');";
        DB::unprepared($updateSql);
        $this->info("Update {$dbName} that modified old domain name '{$this->sourceDomain}' to new one '{$domain}'.");
        
        /**
         * OAuthのクライアント登録
         */
        DB::unprepared('USE `' . config('database.connections.mysql.database') . '`;');
        $clientRepository = app()->make(ClientRepository::class);
        $oauthClient = $clientRepository->create(
            /* userId */   $shop->{config('const.db.shops.ID')},
            /* name   */   $shop->{config('const.db.shops.ID')},
            /* redirect */ config('app.url') . '/auth/callback'
        );
        $this->info('Created OAuth client.');
        
        /**
         * WordPressテンプレート
         */
        // ディレクトリのコピー
        $copyResult = $this->copyDirectoryWithoutLinks(
            /* source */ $this->parentDir . '/' . $this->portalDir . $this->wpTemplatePath,
            /* dest   */ $this->parentDir . '/' . $domain
        );
        if ($copyResult) {
            $this->info("Copied wordpress_template.");

        } else {
            $this->alert('Failed to copy wordpress_template.');
        }

        // wp-config-sampleの内容を取得
        $str = File::get($this->parentDir . '/' . $domain . '/wp-config-sample.madohonpo.php');

        // 認証用ユニークキーの取得
        $apiUrl = 'https://api.wordpress.org/secret-key/1.1/salt/';
        $response = (new \GuzzleHttp\Client)->request('GET', $apiUrl, [
            'allow_redirects' => true,
            'verify' => false,
        ]);
        $body = (string) $response->getBody();

        // ユニークキーを各行ごと分割する
        $generatedApiKeys = explode("\n", $body);
        $generatedApiKeys = array_map('trim', $generatedApiKeys);
        $generatedApiKeys = array_filter($generatedApiKeys, 'strlen');

        // ユニークキーと値の組み合わせを取り出す
        $apiKeys = [];
        foreach ($generatedApiKeys as $generatedApiKey) {
            $matches = [];
            preg_match("/^define\('([A-Z_]+)',\s*'(.+)'\);$/mu", $generatedApiKey, $matches);

            // 抽出結果を格納
            $apiKeys[$matches[1]] = $matches[2];
        }

        // wp-config-sampleを上書きする値を定義する
        $subjects = [
            'DB_NAME' => $dbName,
            'DB_USER' => config('database.connections.mysql.username'),
            'DB_PASSWORD' => config('database.connections.mysql.password'),
            'DB_HOST' => config('database.connections.mysql.host'),
            'DB_CHARSET' => $charset,
            'DB_COLLATE' => $collation,

            'MADO_PORTAL_URL' => config('app.url'),
            'MADO_SHOP_ID' => $shop->{config('const.db.shops.ID')},
            'MADO_CLIENT_ID' => $oauthClient->id,
            'MADO_CLIENT_SECRET' => $oauthClient->secret,
        ];
        $subjects = array_merge($subjects, $apiKeys);

        // wp-config-sampleから取得した文字列を$subjectsで上書きし、wp-config.phpとして保存する
        foreach ($subjects as $key => $value) {
            // ユニークキーに $ が含まれているとき、後方参照として扱われてしまうのでエスケープする
            $value = str_replace('$', '\$', $value);

            // 置換
            $str = preg_replace("/^define\('{$key}',\s*('?)[^']+('?)\);$/mu", "define('{$key}', " . '${1}' . $value . '${2});', $str);
        }
        file_put_contents($this->parentDir . '/' . $domain . '/wp-config.php', $str);
        $this->info("Created wp-config.php.");

        $this->info('Completed.');
        return config('const.command.exit_code.SUCCESS');
    }

    /**
     * ディレクトリを再帰的にコピーする。
     * シンボリックリンクはコピーする対象から除外する。
     * 
     * @param string $source コピー元ディレクトリ
     * @param string $destination コピー先ディレクトリ
     */
    protected function copyDirectoryWithoutLinks(string $source, string $destination)
    {
        // ディレクトリをコピー元に指定していない場合はエラー
        if (! File::isDirectory($source)) {
            return false;
        }

        // コピー先ディレクトリが存在していなければ作成する
        if (! File::isDirectory($destination)) {
            File::makeDirectory($destination, 0777, true);
        }

        $items = new \FilesystemIterator($source);
        foreach ($items as $item) {
            // シンボリックリンクはコピーの対象としない
            if (! is_link($item)) {
                $path = $item->getPathname();
                $target = $destination . '/' . $item->getBasename();

                if ($item->isDir()) {
                    // ディレクトリであれば再帰的にこの関数を呼び出す
                    if (! $this->copyDirectoryWithoutLinks($path, $target)) {
                        return false;
                    }
    
                } else {
                    // このファイルであればコピーを行う
                    if (! File::copy($path, $target)) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
