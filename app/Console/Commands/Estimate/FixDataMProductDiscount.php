<?php

namespace App\Console\Commands\Estimate;

use Illuminate\Console\Command;
use DB;

class FixDataMProductDiscount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixdata:mproductdiscount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    	DB::connection(config('settings.connect_db2'))->table('m_product_discount')->update([
    		'discount_type' => '1枚目から適用'
    	]);
    }
}
