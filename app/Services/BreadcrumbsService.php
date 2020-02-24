<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 * パンくずリストを作成するクラス
 *
 * ルート間の親子関係を構築し、各ルートとページ名を紐付ける。
 * ページ名はcallableで保持し、呼び出し時に遅延実行して決定する。
 *
 * ページ名を決定するcallableにはrequestを引数として渡す。
 * Breadcrumbs::add('front', function ($request) { return 'LIXIL簡易見積りシステムTOP'; });
 */
class BreadcrumbsService
{
    /**
     * ルートの親子関係を示す
     * [$route => $parentRoute]
     */
    private $routeParent = [];

    /**
     * ルートに対してページ名を決定する関数を紐付ける。
     * 1つルートに対して複数のタイトルを保持できるようにするため、valueは配列になるようにする。
     * [route=> [callable, callable, callable]]
     */
    private $titleFuncs = [];

    /**
     * @param string $route 追加するルート
     * @param $title ルートに紐付けたいページタイトルを決定する関数
     * @param string|null $parentRoute 親とするルート
     */
    public function add(string $route, $titleFunc, string $parentRoute = null)
    {
        /**
         * ルートの親子関係の構築
         */
        $this->routeParent[$route] = $parentRoute;

        /**
         * ページ名を決定する関数を格納する
         */
        if (is_callable($titleFunc)) {
            $this->titleFuncs[$route] = [$titleFunc];

        } else if (is_array($titleFunc)) {
            // 配列であった場合、逆順にソートしてから格納する
            // これにより、パンくずの定義の順番と実際の表示の順番を一致させる
            $this->titleFuncs[$route] = array_reverse($titleFunc);
        }
    }

    /**
     * ルートからパンくずを取得する
     *
     * @param string $route パンくずを取得したいルート名
     * @return array [ルート, ページ名]の配列, インデックスが小さいものほど親
     */
    public function get(string $route)
    {
        $result = [];

        $request = app()->request;
        // $workRouteは、現在処理対象となっているルート（以下、対象ルート）を示す
        $workRoute = $route;

        do {
            // 対象ルートのページ名を取得する
            if (! array_key_exists($workRoute, $this->titleFuncs)) {
                throw new \Exception('パンくずリストに' . $workRoute . 'が未登録です。');
            }

            $workTitleFuncs = $this->titleFuncs[$workRoute];
            foreach ($workTitleFuncs as $workTitleFunc) {
                list($url, $title) = $workTitleFunc($request);
                $result = array_prepend($result, [
                    'url' => $url,
                    'title' => $title,
                ]);
            }

            // 親ルートを対象ルートに設定し、対象ルートがnullならループを抜ける
            $workRoute = $this->routeParent[$workRoute];
        } while ($workRoute !== null);

        return $result;
    }

    /**
     * 指定したルートのパンくず情報が登録されているかを判定する
     *
     * @param string $route 登録されているかを確認したいルート
     * @return boolean
     */
    public function has(string $route)
    {
        return array_key_exists($route, $this->titleFuncs);
    }
}
