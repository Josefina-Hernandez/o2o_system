<?php

namespace App\Models\Tostem;


use Illuminate\Support\Facades\DB;
use App\Models\Tostem\{
              Tquotation,
              Mquotation
};

class Quotation  
{
    
     
     
     public $_query;
     
     public $_tq;
     
     public $_mq;
     
     
    
     
     protected $_col_export;
     
     private   $_type_select = 0;
     
     private   $_litmit_onpage = 1000;
     
     public $convertData = true;
     
     public $colum_convert = [];


     public function __construct()
    {
       
          $this->_tq = new Tquotation();
          
          $this->_mq = new Mquotation();
          
          $this->_col_export = [];
   
    
    }
    

    public function getColumnExport(){
         return $this->_col_export;
    }
    
    public function setTypeSelect($_type_select){
         $this->_type_select = $_type_select;
    }


    
  
    
    static function Searchdata($param_where)
    {
         $elo = new Quotation;
         
         $elo->Select();
        
         $elo->Where($param_where);
         $elo->OrderBy();
         $data = $elo->ResulfWithPaginate();
      
      
        return $data;
    }
    
    
    
    
    public function Select(){
         

               $tb1 = $this->_mq->_table_alias;

               $tb2 = $this->_tq->_table_alias;
               
               $QUOTATION_NO = 'CONCAT_WS("_",mail.'.config('const_db_tostem.db.m_mailaddress.column.DEPARTMENT_CODE').', '.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').','.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO').')';
               $NEW_OR_REFORM = $tb1.'.'.config('const_db_tostem.db.m_quotation.column.NEW_OR_REFORM');

               if($this->_type_select == 0){
                    $select =  [
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID') .'  AS stt',
                              'u.'.config('const.db.users.LOGIN_ID'),
                              "DATE_FORMAT(CONVERT(".$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').",DATE), '%Y/%m/%d') AS quotation_date",
                              $QUOTATION_NO.' AS '.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'),                              
                              "CASE 
                                WHEN coalesce(".$NEW_OR_REFORM.",-1) = 1 THEN 'Renovation'
                                WHEN coalesce(".$NEW_OR_REFORM.",-1) = 0 THEN 'New house'
                                ELSE '' END
                              AS " . config('const_db_tostem.db.m_quotation.column.NEW_OR_REFORM'),
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.DESIGN'),
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.COLOR'),
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.W'),
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.H')
                    ];
               }
               if($this->_type_select == 1){
                  $this->_col_export =  $select =  [
                        
                              'No.' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID') .'  AS stt',
                              'User' => 'u.'.config('const.db.users.LOGIN_ID'),
                              'Quotation Date' =>  "DATE_FORMAT(CONVERT(".$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').",DATE), '%Y/%m/%d') AS quotation_date",
                              'Quotation No' => $QUOTATION_NO.' AS '.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'),
                              'New house/Renovation' => "CASE 
                                                  WHEN coalesce(".$NEW_OR_REFORM.",-1) = 1 THEN 'Renovation'
                                                  WHEN coalesce(".$NEW_OR_REFORM.",-1) = 0 THEN 'New house'
                                                  ELSE '' END
                                                AS " . config('const_db_tostem.db.m_quotation.column.NEW_OR_REFORM'),
                              // 'Item' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.ITEM'),
                              // 'HL' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.HL'),
                              'Material' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.MATERIAL'),
                              'Design' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.DESIGN'),
                              'Ref.' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.REF'),
                              'Qty' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.QTY'),
                              // 'One Window' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.ONE_WINDOW'),
                              // 'Joint' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.JOINT'),
                              // 'Screen' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.SCREEN'),
                              // 'Off-Spec' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.OFF_SPEC'),
                              // 'Main Glass' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.MAIN_GLASS'),
                              'Color' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.COLOR_CODE'),
                              'W' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.W'),
                              'H' =>$tb2.'.'.config('const_db_tostem.db.t_quotation.column.H'),
                              'Price' =>$tb2.'.'.config('const_db_tostem.db.t_quotation.column.AMOUNT'),
                              // 'W(Opening)' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.W_OPENING'),
                              // 'H(Opening)' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.H_OPENING'),
                              // 'Special Code' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.SPECIAL_CODE'),
                              // 'Glass Type' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.GLASS_TYPE'),
                              // 'Glass thickness' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.GLASS_HIC_ENESS'),
                              // 'Material reference' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.MATERIAL_REFERENCE'),
                              // 'Material Description' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.MATERIAL_DESCRIPTION'),
                    ];
               }
               
               $select  = [
                         DB::Raw(implode(',', $select))
                  ];
               
              if($this->_type_select == 1){
                   $this->colum_convert = [
                        'p_material'
                       ,'p_glass_type'
                       ,'p_glass_thickness'
                       ,'type_p'
                   ];
                   $select[] = 'p_r.p_material'; 
                   $select[] = 'p_r.p_glass_type'; 
                   $select[] = 'p_r.p_glass_thickness'; 
                   $select[] = 'p_r.type_p'; 
              } 
             
                       
              $this->_query = DB::table($this->_mq->getTable().' AS '. $tb1)->select(
                              $select
                          )->join($this->_tq->getTable().' AS '.$tb2, function ($join) use ($tb1,$tb2) {
                               $join->on($tb1.'.'.config('const_db_tostem.db.m_quotation.column.M_QUOTATION_ID'), '=', $tb2.'.'.config('const_db_tostem.db.t_quotation.column.M_QUOTATION_ID'));
                          })
                         ->leftjoin('users AS u', 'u.id', '=', $tb2.'.'.config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'))
                         ->join('m_mailaddress AS mail', 'mail.id', '=', $tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT'));

              if($this->_type_select == 1){
                         $this->_query->leftjoin(DB::raw('(
                              SELECT DISTINCT design, material as p_material, glass_type as p_glass_type, glass_thickness as p_glass_thickness, COALESCE(material, glass_type, glass_thickness) AS type_p
                              FROM v_product_price_refer
                              UNION DISTINCT
                              SELECT DISTINCT design, material as p_material, glass_type as p_glass_type, glass_thickness as p_glass_thickness, COALESCE(material, glass_type, glass_thickness) AS type_p
                              FROM v_product_price_giesta_refer
                              UNION DISTINCT
                              SELECT DISTINCT design, material as p_material, glass_type as p_glass_type, glass_thickness as p_glass_thickness, COALESCE(material, glass_type, glass_thickness) AS type_p 
                              FROM option_selling_code_price) as p_r'
                             ),function ($join) use ($tb2){
                                          $join->on('p_r.design', '=', $tb2.'.'.config('const_db_tostem.db.t_quotation.column.DESIGN'));
                              });
              }
    }
    
    public function Where($param_where){
         
         
        $tb1 = $this->_mq->_table_alias;
        
        $tb2 = $this->_tq->_table_alias;
        
        $QUOTATION_NO = 'CONCAT_WS("_",mail.'.config('const_db_tostem.db.m_mailaddress.column.DEPARTMENT_CODE').', '.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').','.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO').')';
        
        $this->_query->where($tb1.'.del_flg','=',0);
        $this->_query->whereRaw('( u.'.config('const.db.users.DEL_FLG'). '  =  0  OR   u.'.config('const.db.users.DEL_FLG') . '  <=>  NULL )');

        if(!\Auth::user()->isAdmin()){
            
              $this->_query->where($tb2.'.'.config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'),'=',\Auth::user()->id);
        }
        
        if(!empty($param_where['quotaition_no'])  && $param_where['quotaition_no'] != ''){
             
               $where = $QUOTATION_NO. ' like  ?';
               $this->_query->whereRaw($where, ['%'.$this->escape_like($param_where['quotaition_no']).'%']);//Fix SQL Injection
         }
         
         if(!empty($param_where['time_end']) && $param_where['time_end'] != ''){
           
               $where = 'CONVERT('.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').',DATE) <= ?';
               $this->_query->whereRaw($where, $param_where['time_end']);
               
         }
         
         if(!empty($param_where['time_strart'])  && $param_where['time_strart'] != ''){
              
               $where ='CONVERT('.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').',DATE) >= ?';
               $this->_query->whereRaw($where,$param_where['time_strart']);
               
         }
        
         
    }
    
     public function WhereWithID($param_where){
          
           $tb1 = $this->_mq->_table_alias;
        
           $tb2 = $this->_tq->_table_alias;
          
           if(!empty($param_where['m_quotation_id'])  && $param_where['m_quotation_id'] != ''){
           
               $where = $tb1.'.'.config('const_db_tostem.db.m_quotation.column.M_QUOTATION_ID').' = ?';
               
               $this->_query->whereRaw($where, $param_where['m_quotation_id']);
           
          }
          
     }
    
    
    
    public function OrderBy(){
         
         $tb1 = $this->_mq->_table_alias;
        
         $tb2 = $this->_tq->_table_alias;
         
           $this->_query->orderBy($tb2.'.add_datetime','DESC')
                               ->orderByRaw('CAST('.$tb2.'.'.config('const_db_tostem.db.t_quotation.column.ITEM').'  AS INT)  ASC ')
                               ->orderByRaw('CAST('.$tb2.'.'.config('const_db_tostem.db.t_quotation.column.REF').'  AS INT)  ASC');
          
    }
    
    public function Resulf(){
         return $this->_query->get();
    }
    
    public function ResulfWithPaginate(){
         return $this->_query->paginate($this->_litmit_onpage);
    }
    
    public function _exportDataAdmin($param_where){
                
         $this->Select();
         $this->Where($param_where);
         $this->OrderBy();
       
    }
    
    
    public function _exportDataFrontend($param_where){
                
         $this->Select();
         $this->WhereWithID($param_where);
         $this->OrderBy();
       
    }
    
    private function escape_like(string $value, string $char = '\\'): string
     {
         return str_replace(
             [$char, '%', '_'],
             [$char.$char, $char.'%', $char.'_'],
             $value
         );
     }
    
    
    public function convertData($data){
      
      
          
         if(is_null($data['type_p']) || $data['type_p'] == ''){
              
               $data['material'] = $data['design'];
               $data['design'] = NULL;
               $data['off_spec'] = NULL;
               $data['main_glass'] = NULL;
               $data['color_code'] = NULL;
               $data['w'] = NULL;
               $data['h'] = NULL;
               $data['glass_type'] = NULL;
               $data['glass_hic_eness'] = NULL;
              
         }else{
               $data['material'] = $data['p_material'];
               $data['off_spec'] = 'N';
               $data['main_glass'] = 'Y';
               $data['glass_type'] = $data['p_glass_type'];
               $data['glass_hic_eness'] = $data['p_glass_thickness'];
         }
         if(count($this->colum_convert) > 0){
              foreach ($this->colum_convert as $v){
                   unset($data[$v]);
              }
         }
         return $data;
    }
    
    

}
