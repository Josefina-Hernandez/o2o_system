<?php

use Illuminate\Database\Seeder;

class CreateVMDoorLargeSizeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$table = 'v_m_door_large_size';
        $sql = 'CREATE OR REPLACE TABLE tmp_table
		(
			SELECT 
				product_id, 
				m_model_id, 
				spec3,
				min_height,
				max_height
			FROM m_door_large_size
			WHERE del_flg = 0
		)';

		$sql_insert_tmp = '
			INSERT INTO tmp_table
			SELECT DISTINCT re.product_id, 
							re.m_model_id,
							null as spec3,
							null as min_height,
							null as max_height
			FROM v_product_model_refer re
			WHERE CONCAT(re.product_id, re.m_model_id) not in (SELECT CONCAT(door.product_id,door.m_model_id) FROM m_door_large_size as door WHERE door.del_flg = 0)
			ORDER BY product_id, m_model_id';
		
		 $sql_insert = 'CREATE OR REPLACE TABLE v_m_door_large_size
		(
			SELECT *
			FROM tmp_table
		)';

		try {
        	DB::statement($sql);
        	DB::insert($sql_insert_tmp);
        	echo "GET DATA: OK!" . PHP_EOL;
        } catch (Exception $e) {
        	try{
        		echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        		DB::statement('drop table tmp_table');
        		return false;
	        }catch (Exception $e) {
	        	return false;
	        }
        }

        try {
        	DB::insert($sql_insert);
        	echo "OK!" . PHP_EOL;
        } catch (Exception $e) {
        	echo "Seeder table: $table fail, please check log file!" . PHP_EOL;
        }
        DB::statement('drop table tmp_table');
    }
}
