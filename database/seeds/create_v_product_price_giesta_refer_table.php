<?php

use Illuminate\Database\Seeder;

class CreateVProductPriceGiestaReferTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($k_message = true)
    {
        $table = 'v_product_price_giesta_refer';
    	$sql = "
    		CREATE OR REPLACE TABLE v_product_price_giesta_refer
			(
				SELECT DISTINCT 
					pr.*
				FROM m_selling_code_giesta AS sc
				INNER JOIN giesta_selling_code_price AS pr
					ON
						pr.design = sc.selling_code
				WHERE sc.del_flg = 0 AND sc.product_id = 5 -- GIESTA
				ORDER BY sc.m_selling_code_giesta_id, sc.product_id, pr.giesta_selling_code_price_id
			)
    	";
        $sql_1 = "
        	--
			-- Indexes for table `v_product_price_giesta_refer`
			--
			ALTER TABLE `v_product_price_giesta_refer`
			  ADD PRIMARY KEY (`giesta_selling_code_price_id`),
			  ADD KEY `index_price_key1` (`design`,`width`,`height`,`special`),
			  ADD KEY `index_price_key2` (`design`,`width_org`,`height_org`,`special`);
        ";
        try {
        	DB::statement($sql);
             if($k_message){
               echo "create or replace $table OK!" . PHP_EOL;
             }
        } catch (Exception $e) {
        	echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        	return false;
        }
         try {
        	DB::statement($sql_1);
             if($k_message){
               echo "OK!" . PHP_EOL;
             }
        } catch (Exception $e) {
        	echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        }
    }
}