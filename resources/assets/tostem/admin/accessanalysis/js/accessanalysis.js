var pa = new params();
var p = new pages();

$(function() {
     
	
     
            update_table_height();   
            window.onresize = function(event) {
               update_table_height();
            };    
            

           $('.end-date').keypress(function(event){
               var keycode = (event.keyCode ? event.keyCode : event.which);
               if(keycode == '13'){
                   $('.search-date' ).trigger('click');
               }
           });
           
            $('.start-date').keypress(function(event){
               var keycode = (event.keyCode ? event.keyCode : event.which);
               if(keycode == '13'){
                   $('.search-date' ).trigger('click');
               }
           });
         
          
          
          
            
});



$(document).off("click", "#p_pagination li a.select-page");
$(document).on("click", "#p_pagination li a.select-page", function () {
     
            var page = parseInt($(this).attr('data-page'));
           
            if($('#type-data').val() == '0'){

                     p.page = parseInt(page);

                     load_view_data(page);

            }
            
            if($('#type-data').val() == '1'){

                     p.page = parseInt(page);

                     load_view_data_search(page);

            }
});


$(document).off("click", "#p_pagination li a.next-page");
$(document).on("click", "#p_pagination li a.next-page", function () {
     
            var page = parseInt(p.page) + 1;
           
            if($('#type-data').val() == '0'){

                     p.page = parseInt(page);

                     load_view_data(page);

            }
            
            if($('#type-data').val() == '1'){

                     p.page = page;

                     load_view_data_search(page);

            }
});


$(document).off("click", "#p_pagination li a.prev-page");
$(document).on("click", "#p_pagination li a.prev-page", function () {
     
            var page = parseInt(p.page) - 1;
           
            if($('#type-data').val() == '0'){

                    
                     p.page = page;

                     load_view_data(page);

                   
            }
            
            if($('#type-data').val() == '1'){

                    
                     p.page = page;

                     load_view_data_search(page);

                   
            }
});



$(document).off("click", ".clear_input_search");
$(document).on("click", ".clear_input_search", function () {
     
               $('.start-date').val('');
               $('.end-date').val('');
               //pa.param = _set_param( null, null);
});


$(document).off("click", ".search-date");
$(document).on("click", ".search-date", function () {
          
          $('#type-data').val('1');
          
          
        
          
          var $_time_strart =   $('.start-date').val();
          
          var $_time_end =   $('.end-date').val();
          
          if($_time_strart != ''){
               if(!isValidDate($_time_strart)){
                    alert("Invalid input time.");
                     return false;
               }
          }
         if($_time_end != ''){
               if(!isValidDate($_time_end)){
                    alert("Invalid input time.");
                     return false;
               }
          }
          
          p.page = 1;
          pa.param = _set_param($_time_strart, $_time_end);
       
          
          var formData = new FormData();

          formData.append("_token",config._token);
          
          $(".loader").show();
          
           jQuery.ajax({
                    type: 'GET',
                    url: config.routes._searchdata+ '?time_strart=' + $_time_strart + '&time_end=' + $_time_end,
                    async: true,
                    cache: false,
                    //data: formData,
                    contentType: false,
                    processData: false,
                    complete: function () {
                                $(".loader").hide();
                    },
                    success: function (data) {
                         
                         if(data.status == 'auth')
                         {
                             alert(data.msg);

                             if(data.key == 0){
                                window.location.reload();
                             }
                             $(".loader").hide();
                             return false;
                         }   
                      
                         $('#content-access-analysis').empty().append(data.html);
                    
                          update_table_height();
                    },
                   error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                   }
           });
});


$(document).off("click", ".download-file-csv");
$(document).on("click", ".download-file-csv", function () {
     
          var $_time_strart = pa.param._time_strart;
          var $_time_end = pa.param._time_end;

          //pa.param = _set_param($_quotaition_no, $_time_strart, $_time_end);
          //console.log(pa.param)
          
          var formData = new FormData();
          
         
          formData.append('time_start',$_time_strart);
          formData.append('time_end',$_time_end);
          formData.append("_token",config._token);
          
          $(".loader").show();
          
           jQuery.ajax({
                    type: 'POST',
                    url: config.routes._download,
                    async: true,
                    cache: false,
                    data: formData,
                    contentType: false,
                    processData: false,
                    complete: function () {
                                $(".loader").hide();
                    },
                    success: function (data) {
                         if(data.status == 'auth')
                         {
                             alert(data.msg);

                             if(data.key == 0){
                                window.location.reload();
                             }
                             $(".loader").hide();
                             return false;
                         }
                         if(data.status == 'OK'){
                               var _url =  config.routes._download +'?time_strart=' + $_time_strart +'&time_end=' + $_time_end;
                               window.location.href = _url;
                         }
                    },
                   error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                   }
           });
          
          
});




function isValidDate(dateString) {
     var regEx = /^\d{4}\/\d{2}\/\d{2}$/;
     return dateString.match(regEx) != null;
}



function update_table_height() {
        var box = $("#parentdata");
        var window_h_margin = 324;
        var window_h = $('#content-body').height();
        var set_h = window_h - window_h_margin;
        box.height(set_h);
  }
  
  
  
  function load_view_data(page) {
       
     $(".loader").show();
     
     jQuery.ajax({
          
        type: 'GET',
        url: '?page=' + page,
        async: true,
        cache: false,
       complete: function () {
                                $(".loader").hide();
        },
        success: function (data) {
                    
                    if(data.status == 'auth')
                         {
                             alert(data.msg);

                             if(data.key == 0){
                                window.location.reload();
                             }
                             $(".loader").hide();
                             return false;
                         }   
                       

                    $('#content-access-analysis').empty().append(data.html);
                    
                    update_table_height();
        },
        error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                   }

    });
}


function load_view_data_search(page) {
  
 
 
 
  var $_time_strart = pa.param._time_strart;
  var $_time_end = pa.param._time_end;
 
  var formData = new FormData();

  formData.append("_token", config._token);
  
  $(".loader").show();
  
  jQuery.ajax({
       
    type: 'GET',
    url: config.routes._searchdata+ '?time_strart=' + $_time_strart + '&time_end=' + $_time_end+'&page=' + page,
    async: true,
    cache: false,
    //data: formData,
    complete: function () {
           $(".loader").hide();
    },
    success: function (data) {
         
       if(data.status == 'auth')
         {
              alert(data.msg);

              if(data.key == 0){
                 window.location.reload();
              }
              $(".loader").hide();
              return false;
       } 
       
      $('#content-access-analysis').empty().append(data.html);            
      update_table_height();
      
    },
    error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                   }
  });
  
}

                                  
                                    

function pages(){
     
     var _page = 1;
     
     return {
        get page() {
               return _page;
        },
        set page(val) {
            _page = val;
         }
      } 
}

function _set_param($_time_strart, $_time_end){
     var _param = {
               _time_strart:$_time_strart,
               _time_end:$_time_end,
        }   
     return _param;
}


function params(){
     
      var _param = {
               _time_strart:'',
               _time_end:'',
        } 
      return {
        get param() {
               return _param;
        },
        set param(val) {
            _param = val;
         }
      }   
}

