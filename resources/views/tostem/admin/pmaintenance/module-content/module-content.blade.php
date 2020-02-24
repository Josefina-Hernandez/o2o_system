<div class="container selection-content">
        <h2 class="t-center" style="margin-top: 50px;font-size: xx-large;">User management</h2>
        
        
        <div class="import-file">
             
                   <div class="from-importfile">
                         <div class="form-group">
                              <div class="input-group input-file">
                              <span class="input-group-btn">
                              <button id="file_u" class="btn btn-default btn-choose" type="button">Select File</button>
                              </span>
                              <input id="fileInput" type="text" name="file-name" class="form-control file_upload" placeholder='Choose a file...' />
                              </div>
                              
                         </div>
                   </div>
             <div class="button-import">
                  <button class="btn" id="import-fle">import</button>
             </div>
                         
        </div>
        
        <div class="select-time-serach">
                   
                         <div class="form-group m-t-30">
                             <label class="label-group m-r-15px">Date</label>
                             <div class="date-from">
                                 <input type="text" name="date_from" class="form-control input-text datepicker start-date" placeholder='From : yyyy/mm/dd' value="{{ Request::get('date_from') }}" autocomplete="off" />
                             </div>
                             ～
                             <div class="date-to">
                                 <input type="text" name="date_to" class="form-control input-text datepicker end-date" placeholder='To : yyyy/mm/dd' value="{{ Request::get('date_to') }}" autocomplete="off" />
                             </div>
                             <button type="submit" class="btn btn-orange color-fff search-date">Search</button>
                             <button type="button" class="btn btn-orange color-fff clear_input_search">Clear</button>

                             <!-- rm tam
                             <a href="{{ url()->current() }}/statistics"><button type="button" class="btn btn-csv">サマリー情報</button></a>
                             -->

                         </div>
                     
        </div>
    
        <div class="content-history">
               <div class="table-wrap">
                     @include('tostem.admin.pmaintenance.module-content.module-headertable')
                     <div style="overflow-y:scroll; overflow-x:hidden;height: auto;" id="parentdata">
                         <div  id="list-content">
                             @include('tostem.admin.pmaintenance.module-content.module-listhistory')
                         </div>
                     </div>
                     
               </div>
        </div>
        <div class="p-paginate">
          
        </div>
          <center class="mt-5"><a href="{{ route('admin.lixil') }}" class="btn-back">Back</a></center>

    </div>
