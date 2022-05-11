<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class CheckData
{
    
     
 public function _get_data1(){
         
         $query = "
               
               SELECT DISTINCT selling_code, 'm_selling_code' AS table_name, product_name, spec_name, NULL AS ctg_name
               FROM m_selling_code AS m_scode
               LEFT JOIN product_trans AS p_trans ON p_trans.product_id = m_scode.product_id AND p_trans.m_lang_id = 1
               LEFT JOIN m_selling_spec_trans AS s_trans ON s_trans.spec_code = m_scode.spec1 AND s_trans.m_lang_id = 1
            
               
               UNION 
               
               SELECT DISTINCT selling_code, 'm_selling_code_giesta' AS table_name , product_name, NULL AS spec_name,NULL AS ctg_name
               FROM m_selling_code_giesta AS m_scode
               LEFT JOIN product_trans AS p_trans ON p_trans.product_id = m_scode.product_id AND  p_trans.m_lang_id = 1 
               
               UNION
               
               SELECT DISTINCT selling_code, 'm_option_selling_code' AS table_name , product_name, spec_name, ctg_name
               FROM m_option_selling_code AS m_scode
               LEFT JOIN product_trans AS p_trans ON p_trans.product_id = m_scode.product_id AND p_trans.m_lang_id = 1
               LEFT JOIN m_selling_spec_trans AS s_trans ON s_trans.spec_code = m_scode.spec1  AND s_trans.m_lang_id = 1
               LEFT JOIN ctg_trans AS c_trands ON c_trands.ctg_id = m_scode.option_ctg_spec_id AND c_trands.m_lang_id = 1
             
               UNION 
               
               SELECT DISTINCT selling_code, 'm_option_selling_code_giesta' AS table_name , product_name, NULL AS spec_name,ctg_name
               FROM m_option_selling_code_giesta AS m_scode
               LEFT JOIN product_trans AS p_trans ON p_trans.product_id = m_scode.product_id AND p_trans.m_lang_id = 1 
               LEFT JOIN ctg_trans AS c_trands ON c_trands.ctg_id = m_scode.option_ctg_spec_id AND c_trands.m_lang_id = 1
              

           ";
         yield DB::select($query);
         
    }
     public function _get_data2(){
         
         $query = "
               SELECT DISTINCT design, 'product_selling_code_price' AS table_name 
               FROM  product_selling_code_price
               WHERE product_selling_code_price_id NOT IN(SELECT product_selling_code_price_id FROM product_selling_code_price WHERE width = 999 AND height = 999)
               UNION 
               SELECT DISTINCT design, 'option_selling_code_price' AS table_name 
               FROM  option_selling_code_price
               
           ";
         
          $_pdo  =  \DB::getPdo();
         
          $statement = $_pdo->prepare($query);

          $statement->execute();

          $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
          
          return $result;
         
    }
    
    
    public function _insert_data_dummy($data){
         
               if(count($data) > 0){
                    foreach ($data as $v){
                         $this->_query_insert_data($v);
                    }
               }
               
    }
    
    private function _query_insert_data($selling_code){
         
         $check = \DB::table('product_selling_code_price')->select('*')->where('design','=',$selling_code)->limit(1)->get();
         
        if($check->count() == 0){
             
         \DB::table('product_selling_code_price')->insert(
               [
                    'design' =>$selling_code
                   , 'width' => 999
                   , 'height' => 999
                   , 'special' => NULL
                   , 'amount' => 0
                   , 'width_org' => 999
                   , 'height_org' => 999
                ]
           );
         
        }
         
    }
     
     
}
