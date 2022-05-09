<?php

use Illuminate\Database\Seeder;

class CreateVProductModelReferTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$table = 'v_product_model_refer';
    	$sql = "
    		CREATE OR REPLACE TABLE v_product_model_refer
			(
				SELECT DISTINCT 
					sc.m_selling_code_id
					, sc.product_id
					, ms.m_model_id
				FROM m_model_spec AS ms
				INNER JOIN m_selling_code AS sc
						ON
							(ms.product_id IS NULL OR sc.product_id = ms.product_id)
							AND (ms.spec1 IS NULL OR sc.spec1 = ms.spec1 )
							AND ( ms.spec2 IS NULL OR sc.spec2 = ms.spec2 )
							AND ( ms.spec3 IS NULL OR sc.spec3 = ms.spec3 )
							AND ( ms.spec4 IS NULL OR sc.spec4 = ms.spec4 )
							AND ( ms.spec5 IS NULL OR sc.spec5 = ms.spec5 )
							AND ( ms.spec6 IS NULL OR sc.spec6 = ms.spec6 )
							AND ( ms.spec7 IS NULL OR sc.spec7 = ms.spec7 )
							AND ( ms.spec8 IS NULL OR sc.spec8 = ms.spec8 )
							AND ( ms.spec9 IS NULL OR sc.spec9 = ms.spec9 )
							AND ( ms.spec10 IS NULL OR sc.spec10 = ms.spec10 )
							AND ( ms.spec11 IS NULL OR sc.spec11 = ms.spec11 )
							AND ( ms.spec12 IS NULL OR sc.spec12 = ms.spec12 )
							AND ( ms.spec32 IS NULL OR sc.spec32 = ms.spec32 ) -- Add BP_O2OQ-6 MinhVnit 20200625 
							AND ( ms.spec33 IS NULL OR sc.spec33 = ms.spec33 ) -- Add BP_O2OQ-6 MinhVnit 20200625 
							AND ( ms.spec37 IS NULL OR sc.spec37 = ms.spec37 ) -- Add BP_O2OQ-9 MinhVnit 20200901
							AND ( ms.spec56 IS NULL OR sc.spec56 = ms.spec56 )
							AND ( ms.spec14 IS NULL OR sc.spec14 = ms.spec14 ) -- Add BP_O2OQ-27 MinhVnit 20210819
							AND ( ms.spec39 IS NULL OR sc.spec39 = ms.spec39 ) -- Add BP_O2OQ-27 MinhVnit 20210819
							AND sc.del_flg = 0
				WHERE ms.del_flg = 0
				ORDER BY sc.m_selling_code_id, sc.product_id, ms.m_model_id
			)
    	";
    	try {
    		DB::statement($sql);  
    		echo "OK!" . PHP_EOL;
        } catch (\Exception $e) {
        	echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        }
    }
}