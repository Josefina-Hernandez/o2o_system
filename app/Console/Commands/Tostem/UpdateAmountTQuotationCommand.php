<?php

namespace App\Console\Commands\Tostem;

use Illuminate\Console\Command;
use DB;

class UpdateAmountTQuotationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatedata:tquotationamount';

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
        $queryProduct = "
            UPDATE 
                t_quotation AS t_q 
                INNER JOIN v_product_price_refer AS v_p 
                ON t_q.design = v_p.design 
                AND COALESCE(t_q.w, '') = COALESCE(v_p.width, '') 
                AND COALESCE(t_q.h, '') = COALESCE(v_p.height, '')
                AND v_p.special IS NULL
            SET 
                t_q.amount = v_p.amount,
                t_q.upd_datetime = now()
            WHERE
                t_q.amount IS NULL
        ";

        $queryOption = "
            UPDATE 
                t_quotation AS t_q 
                INNER JOIN option_selling_code_price AS o_s 
                ON t_q.design = o_s.design 
                AND COALESCE(t_q.w, '') = COALESCE(o_s.width, '') 
                AND COALESCE(t_q.h, '') = COALESCE(o_s.height, '')
            SET 
                t_q.amount = o_s.amount,
                t_q.upd_datetime = now()
            WHERE
                t_q.amount IS NULL
        ";

        $queryOptionCheckNull = "
            UPDATE 
                t_quotation AS t_q 
                INNER JOIN option_selling_code_price AS o_s 
                ON t_q.design = o_s.design 
                AND o_s.width IS NULL
                AND o_s.height IS NULL
            SET 
                t_q.amount = o_s.amount,
                t_q.upd_datetime = now()
            WHERE
                t_q.amount IS NULL
        ";


        $queryGiesta = "
            UPDATE 
                t_quotation AS t_q 
                INNER JOIN v_product_price_giesta_refer AS v_p_g 
                ON t_q.design = v_p_g.design 
                AND COALESCE(t_q.w, '') = COALESCE(v_p_g.width, '') 
                AND COALESCE(t_q.h, '') = COALESCE(v_p_g.height, '')
                AND v_p_g.special IS NOT NULL
                AND v_p_g.special = t_q.color_code
            SET 
                t_q.amount = v_p_g.amount,
                t_q.upd_datetime = now()
            WHERE
                t_q.amount IS NULL
        ";

        DB::statement($queryProduct);
        DB::statement($queryOption);
        DB::statement($queryOptionCheckNull);
        DB::statement($queryGiesta);
      
    }
}
