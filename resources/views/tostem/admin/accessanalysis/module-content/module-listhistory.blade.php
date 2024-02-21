<div class="content-history">
       <div class="table-wrap">
             @include('tostem.admin.accessanalysis.module-content.module-headertable')
             <div style="overflow-y:scroll; overflow-x:hidden;height: auto;" id="parentdata">
                 <div  id="list-content">
                      <table id="content-table" >
                          <colgroup>
                              <col style="width: 4%;">
                               <col style="width: 27.4%;">
                               <col style="width: 9.7%;">
                               <col style="width: 13.7%;">
                               <col style="width: 13.7%;">
                               <col style="width: 13.7%;">
                               <col style="width: *;">     
                           </colgroup>
                        <tbody id="list-data">
                            @include('tostem.admin.accessanalysis.module-content.module-child-data')
                        </tbody>
                    </table>
                 </div>
             </div>

       </div>
</div>

<div class="p-paginate">
     <div id='p_pagination'>
          {{ $_all_historys->links() }}
     </div>  
   
</div>





