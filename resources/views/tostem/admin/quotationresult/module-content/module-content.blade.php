<div class="container selection-content">
        <h2 class="t-center" style="margin-top: 50px;font-size: xx-large;">Quotation Result</h2>
        
    
        
       <div class="select-time-serach">
             
               <div class="form-group m-t-30">
                             <label class="label-group m-r-15px">Quotaition No</label>
                             <div class="date-from">
                                 <input type="text" name="quotaition_no" class="form-control input-text quotaition-no" placeholder='' value=""  />
                             </div>
                 </div>
                         
        </div>
        
        <div class="select-time-serach">
                   
                         <div class="form-group m-t-30">
                             <label class="label-group m-r-15px">Quotation date</label>
                             <div class="date-from">
                                 <input type="text" name="date_from" class="form-control input-text datepicker start-date" placeholder='From : yyyy/mm/dd' value="{{ Request::get('date_from') }}" autocomplete="off" />
                             </div>
                             ～
                             <div class="date-to">
                                 <input type="text" name="date_to" class="form-control input-text datepicker end-date" placeholder='To : yyyy/mm/dd' value="{{ Request::get('date_to') }}" autocomplete="off" />
                             </div>
                             <button type="submit" class="btn btn-orange color-fff search-date">Search</button>
                             <button type="button" class="btn btn-orange color-fff clear_input_search">Clear</button>
                             <button type="button" class="btn btn-orange color-fff download-file-csv">CSV Download</button>

                             <!-- rm tam
                             <a href="{{ url()->current() }}/statistics"><button type="button" class="btn btn-csv">サマリー情報</button></a>
                             -->

                         </div>
                     
        </div>
    
        <div class="content-history">
               <div class="table-wrap">
                     @include('tostem.admin.quotationresult.module-content.module-headertable')
                     <div style="overflow-y:scroll; overflow-x:hidden;height: auto;" id="parentdata">
                         <div  id="list-content">
                             @include('tostem.admin.quotationresult.module-content.module-listhistory')
                         </div>
                          <div id="view-loading-data">
                                   
                            </div>
                     </div>
                     
               </div>
        </div>
        <div class="p-paginate">
          
        </div>
     
          @if(Auth::user()->isAdmin())
          <center class="mt-5"><a data-href="{{ route('admin.lixil') }}" class=" rendect-page btn-back">Back</a></center>
          @else
          <center class="mt-5"><a data-href=" {{ route('admin.shop',[Auth::user()->shop->id]) }}" class=" rendect-page btn-back">Back</a></center>
          @endif
          <input type="hidden" id="type-data" value="0">
        
    </div>
