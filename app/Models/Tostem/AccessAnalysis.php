<?php

namespace App\Models\Tostem;


use Illuminate\Support\Facades\DB;
use App\Models\Tostem\{
              Tquotation,
              Mquotation
};

class AccessAnalysis  
{
    
     
     
     public $_query;
     
     public $_tq;
     
     public $_mq;
     
     
    
     
     protected $_col_export;
     
     private   $_type_select = 0;
     
     private   $_litmit_onpage = 10;
     
     
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
         $elo = new AccessAnalysis;
         
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
              
               if($this->_type_select == 0){
                    $select =  [
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID') .'  AS stt',
                              'u.'.config('const.db.users.LOGIN_ID'),
                              $tb1.".upd_datetime AS quotation_date",
                              $QUOTATION_NO.' AS '.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'),
                              $tb2.'.'.config('const_db_tostem.db.t_quotation.column.DESIGN'),
                              $tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_SESSION'),
                              'CONCAT_WS("・",'.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.BUTTON_PDF').','.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL').') AS button_click'
                    ];
               }
               if($this->_type_select == 1){
                  $this->_col_export =  $select =  [
                        
                              'No.' => $tb2.'.'.config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID') .'  AS stt',
                              'Session ID' =>  $tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_SESSION'),
                              'User' =>  'u.'.config('const.db.users.LOGIN_ID'),
                              'Quotation Date' => $tb1.".upd_datetime AS quotation_date",
                              'Quotation No' =>  $QUOTATION_NO.' AS '.config('const_db_tostem.db.m_quotation.column.QUOTATION_NO'),
                              'Selling Code' =>  $tb2.'.'.config('const_db_tostem.db.t_quotation.column.DESIGN'),
                              'Operation' =>  'CONCAT_WS("・",'.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.BUTTON_PDF').','.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.BUTTON_MAIL').') AS button_click',
                    ];
               }
              
               
              $this->_query = DB::table($this->_mq->getTable().' AS '. $tb1)->select(
                          DB::Raw(implode(',', $select))
                          )->join($this->_tq->getTable().' AS '.$tb2, function ($join) use ($tb1,$tb2) {
                               $join->on($tb1.'.'.config('const_db_tostem.db.m_quotation.column.M_QUOTATION_ID'), '=', $tb2.'.'.config('const_db_tostem.db.t_quotation.column.M_QUOTATION_ID'));
                          })
                         ->leftjoin('users AS u', 'u.id', '=', $tb2.'.'.config('const_db_tostem.db.t_quotation.column.QUOTATION_USER'))
                         ->join('m_mailaddress AS mail', 'mail.id', '=', $tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DEPARMENT'));         

    }
    
    public function Where($param_where){
         
         
        $tb1 = $this->_mq->_table_alias;
        
        $tb2 = $this->_tq->_table_alias;
        $this->_query->where($tb1.'.del_flg','=',0);
        $this->_query->whereRaw('( u.'.config('const.db.users.DEL_FLG'). '  =  0  OR   u.'.config('const.db.users.DEL_FLG') . '  <=>  NULL )');
        
        if(!empty($param_where['time_end']) && $param_where['time_end'] != ''){
           
               $where = 'CONVERT('.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').',DATE) <= ?';
               $this->_query->whereRaw($where, $param_where['time_end']);
               
         }
         
         if(!empty($param_where['time_strart'])  && $param_where['time_strart'] != ''){
              
               $where ='CONVERT('.$tb1.'.'.config('const_db_tostem.db.m_quotation.column.QUOTATION_DATE').',DATE) >= ?';
               $this->_query->whereRaw($where, $param_where['time_strart']);
               
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
         
         $this->_query->orderBy($tb2.'.'.config('const_db_tostem.db.t_quotation.column.T_QUOTATION_ID'),'DESC');
          
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
    
    

}
