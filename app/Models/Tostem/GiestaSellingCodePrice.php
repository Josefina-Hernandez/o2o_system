<?php

namespace App\Models\Tostem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Schema;
use App\Models\Tostem\{
              ProductSellingCodePrice,
};


class GiestaSellingCodePrice extends Model
{
   
     /**
     * 初期値を決定する
     *
     * @var array
     */
    protected $attributes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable;

    /**
     * 日付へキャストする属性
     *
     * @var array
     */
     protected $table;
     
     protected $primaryKey ;
     

     protected $_table_selling_giesta = 'm_selling_code_giesta';
     
     protected $_table_tmp_giesta = 'tmp_selling_code_giesta';
     
     private $_limit_leght = 1000;
     
     private $_pdo;
     
     public function __construct(array $attributes = [])
    {
          
         $this->primaryKey = config('const_db_tostem.db.giesta_selling_code_price.column.ID');
          
         $this->table = config('const_db_tostem.db.giesta_selling_code_price.nametable');
         
       
         
         $this->fillable = [
                    config('const_db_tostem.db.giesta_selling_code_price.column.DESIGN'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.WIDTH'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHT'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.SPECIAL'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.AMOUNT'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.WIDTHORG'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.HEIGHTORG'),
                      /* add new 2020/05/20 */
                    config('const_db_tostem.db.giesta_selling_code_price.column.MATERIAL'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_TYPE'),
                    config('const_db_tostem.db.giesta_selling_code_price.column.GLASS_THICKNESS'),  
                     /* end add new 2020/05/20 */
             ];
         
        parent::__construct($attributes);
        
         $this->_pdo =  \DB::getPdo();
        
    }
   
    
    public function CreateDataGiesta(){
         
         try {
                    \DB::beginTransaction();
         
                    $this->_clone_data_tmp_giesta();
                    $this->_update_data();
                    $this->_query_truncate();
                    $this->_add_data_to_table_giesta();
                    $this->_drop_table_tmp();

                    \DB::commit();         
         
         } catch (Exception $ex) {
                $this->_drop_table_tmp();
         } 
      
    }


    
    private function _clone_data_tmp_giesta(){
         
         $m_product_price = new ProductSellingCodePrice();
          
         Schema::dropIfExists($this->_table_tmp_giesta);

         $query = "
                CREATE TABLE ".$this->_table_tmp_giesta." AS 
                SELECT DISTINCT  *
                FROM      ".$m_product_price->getTable()." AS tb1
                INNER JOIN  ".$this-> _table_selling_giesta ." AS tb2 ON  tb2.selling_code <=> tb1.design
                WHERE tb2.del_flg = 0 AND tb2.product_id = 5 
           ";
          \DB::statement($query);
          

    }
    
    
    private function _update_data(){
         
      $this->_data_update()->chunk($this->_limit_leght, function($datas){
           
               if($datas->count() > 0){
                    foreach($datas as $v){
                         
                         $flg = FALSE;
                         
                         $v_org = $v->d_after;
                         
                         if(strlen($v->d_after) < 4){
                              $v_org =  sprintf("%s".trim($v->d_after), 0);
                         }
                         
                         $_query = 'UPDATE '.$this->_table_tmp_giesta.' ';

                         if($v->d_size == 'Height'){
                              $flg = TRUE;
                              $_query .= "SET height = '".trim($v->d_after)."' ";//   , height_org ='".$v_org."' ";
                              
                              $_query.= 'WHERE spec51 <=>  '.$v->spec51.'   AND   spec53 <=> '.$v->spec53.'   AND height <=> '.$v->d_before.' ';
                              
                              if(!is_null($v->spec56) && is_null($v->d_except)){
                                  $_query .= '  AND spec56 <=> '.$v->spec56.' ';
                              }
                              if(!is_null($v->d_except)){
                                  $_query .= '  AND spec56  != '.$v->d_except.' ';
                              }
                              
                         }

                         if($v->d_size == 'Width'){
                              $flg = TRUE;
                              $_query .= "SET width = '".trim($v->d_after)."' ";//, width_org ='".$v_org."' ";
                              $_query.= 'WHERE spec51 <=>  '.$v->spec51.'   AND   spec53 <=> '.$v->spec53.'   AND width <=> '.$v->d_before.' ';
                              
                              if(!is_null($v->spec56) && is_null($v->d_except)){
                                  $_query .= '  AND spec56 <=> '.$v->spec56.' ';
                              }
                              if(!is_null($v->d_except)){
                                   
                                  $_query .= '  AND spec56  != '.$v->d_except.' ';
                                  
                              }
                         }
                         
                      
                         if($flg){
							
                                   $this->_pdo->prepare($_query)->execute();
                                 //  echo "used insert ".memory_get_usage() . '  <br>'  ; 
                         }
                       
                         
                    }
                    
               }
               
      });

         
    }
    
    private function _add_data_to_table_giesta(){
         
         $_query = "  INSERT INTO ".$this->getTable()." ( ".implode(', ', $this->fillable).")
                              SELECT   ".implode(', ', $this->fillable)."
                              FROM      $this->_table_tmp_giesta";
         $this->_pdo->prepare($_query)->execute();
         
    }
     private function _query_truncate(){
           $query = "TRUNCATE TABLE ".$this->getTable().";";
           $this->_pdo->prepare($query)->execute(); 
      }
    
    
    
    private function _drop_table_tmp(){
           Schema::dropIfExists($this->_table_tmp_giesta);
    }

    private function _data_update(){
         
          $data = DB::table('t_data_convert_update_data_giesta')->select(
            DB::Raw('*')
          )->whereRaw('flg_action = 1')->OrderBy('id','ASC');
          
          return $data;
          
    }

}
