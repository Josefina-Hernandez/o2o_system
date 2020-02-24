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
    	$sql = "
    		CREATE TABLE v_product_model_refer
			(
				SELECT DISTINCT 
					sc.product_id
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
							AND sc.del_flg = 0
				WHERE ms.del_flg = 0
				ORDER BY sc.product_id, ms.m_model_id
			)
    	";
        DB::statement($sql);
    }
}