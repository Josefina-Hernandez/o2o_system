<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        app("db")->listen(function(\Illuminate\Database\Events\QueryExecuted $query) {
            /** @var LoggerInterface $log */

            // UPDATE文, INSERT文, DELETE文が発行された場合、ロギングを行う
            if (starts_with($query->sql, ['update', 'insert', 'delete'])) {
                // 変数の内容をSQL文に埋め込む
                $sql = $query->sql;
                foreach ($query->bindings as $binding) {
                    if (is_string($binding)) {
                        $binding = "'{$binding}'";
                    } else if ($binding === null) {
                        $binding = 'NULL';
                    } else if ($binding instanceof \Carbon\Carbon) {
                        $binding = "'{$binding->toDateTimeString()}'";
                    } else if ($binding instanceof \DateTime) {
                        $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                    }

                    $sql = preg_replace("/\?/", $binding, $sql, 1);
                }

                app()->make('mado_log')->info('Xs001 DB更新のSQL文が発行されました。', ['sql' => $sql, 'time' => $query->time]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mado_log', function () {
            return new \App\Services\MadoLogService;
        });
    }
}
