<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CitiesTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:cities {file_name : File name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the add data (ADD_YYMM.ZIP) of the city into cities table';

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
        // コマンドパラメータの取得
        $file_name = $this->argument('file_name');

        if (Storage::disk('local')->exists('private/csv/' . $file_name)) {
            // 市区町村テーブルの更新
            app()->make('cities_csv')->saveCities($file_name);
            $this->info('Cities table updated successfully.');
        } else {
            $this->info('File name is incorrect.');
        }
    }
}
