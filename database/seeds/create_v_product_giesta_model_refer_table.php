<?php

use Illuminate\Database\Seeder;

class CreateVProductGiestaModelReferTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$table = 'v_product_giesta_model_refer';
    	$sql = "
    		CREATE OR REPLACE TABLE v_product_giesta_model_refer
			(
				SELECT DISTINCT 
					sc.m_selling_code_giesta_id
					, sc.product_id
					, ms.m_model_id
				FROM m_model_spec AS ms
				INNER JOIN m_selling_code_giesta AS sc
						ON
							sc.del_flg = 0
							AND sc.spec56 IS NOT NULL -- (chỉ có data của nhóm Main panel/Sub panel)
							AND sc.spec56 = ms.spec56
				WHERE ms.del_flg = 0
				ORDER BY sc.m_selling_code_giesta_id, sc.product_id, ms.m_model_id
			)
    	";
        try {
        	DB::statement($sql);
        	echo "OK!" . PHP_EOL;
        } catch (Exception $e) {
        	echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        }
    }
}