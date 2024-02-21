var pa = new params();
var p = new pages();

$(function() {
     
	
     
            update_table_height();   
            window.onresize = function(event) {
               update_table_height();
            };    
            
          
          $('#parentdata').scroll(function() { //detect page scroll
               
                   
                   
                    var _element = document.getElementById("parentdata");
                    if(_element.scrollTop + _element.offsetHeight >= (_element.scrollHeight-31000)) { //if user scrolled from top to bottom of the page
                         
                             if($('#type-data').val() == '0'){
                                   if($('#parentdata #view-loading-data #loading-data').length == 0){
                                              var temp = _template_viewload();
                                              $('#parentdata #view-loading-data').append(temp);
                                              var $pa =  p.page;
                                              p.page = $pa + 1;
                                              
                                              load_view_data($pa);
                                           
                                    }
                              }
                              
                              if($('#type-data').val() == '1'){
                                   if($('#parentdata #view-loading-data #loading-data').length == 0){
                                              var temp = _template_viewload();
                                              $('#parentdata #view-loading-data').append(temp);
                                              var $pa =  p.page;
                                              p.page = $pa + 1;
                                              load_view_data_search($pa);
                                            
                                    }
                              }
                              
                    }
          });   
          
          $('.quotaition-no').keypress(function(event){
               var keycode = (event.keyCode ? event.keyCode : event.which);
               if(keycode == '13'){
                   $('.search-date' ).trigger('click');
               }
           });
           
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


$(document).off("click", ".clear_input_search");
$(document).on("click", ".clear_input_search", function () {
     
               $('.start-date').val('');
               $('.end-date').val('');
               $('.quotaition-no').val('');
               //pa.param = _set_param(null, null, null);
           
               
});


$(document).off("click", ".search-date");
$(document).on("click", ".search-date", function () {
          
          $('#type-data').val('1');
          
          p.page = 2;
          var _element = document.getElementById("parentdata");
          _element.scrollTop = 0;
          
          var $_quotaition_no =   $('.quotaition-no').val();
          
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
          
          pa.param = _set_param($_quotaition_no, $_time_strart, $_time_end);
          
          
          var formData = new FormData();

          var data = {
                         quotaition_no:$_quotaition_no
                         ,time_strart : $_time_strart
                         ,time_end:$_time_end
                         ,_token:config._token
                    };
                    
         var recursiveEncoded = $.param( data );        
        
          $(".loader").show();
          
           jQuery.ajax({
                    type: 'GET',
                    url: config.routes._searchdata,
                    data:recursiveEncoded,
                    async: true,
                    cache: false,
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
                         if(data.status == 'full'){
                              $('#type-data').val('3');
                              $('#list-data').append(_template_end());
                              return false;
                         }
                         $('#list-data').empty();
                         $('#list-data').append(data.html);
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
     
          var $_quotaition_no = pa.param._quotaition_no;
          var $_time_strart = pa.param._time_strart;
          var $_time_end = pa.param._time_end;

          //pa.param = _set_param($_quotaition_no, $_time_strart, $_time_end);
          //console.log(pa.param)
          var formData = new FormData();
          formData.append('quotaition_no',$_quotaition_no);
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
                                
                              var data = {
                                                    quotaition_no:$_quotaition_no
                                                    ,time_strart : $_time_strart
                                                    ,time_end:$_time_end
                                                    ,_token:config._token
                                               };

                                var recursiveEncoded = $.param( data );   
                               var _url =  config.routes._download +'?'+recursiveEncoded;
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




function update_table_height() {
        var box = $("#parentdata");
        var window_h_margin = 324;
        var window_h = $('#content-body').height();
        var set_h = window_h - window_h_margin;
        box.height(set_h);
  }
  
  
  
  function load_view_data(page) {
  
     jQuery.ajax({
          
        type: 'GET',
        url: '?page=' + page,
        async: true,
        cache: false,

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


                    $('#parentdata #view-loading-data #loading-data').remove();
                    
                    if(data.status == 'full'){
                              $('#type-data').val('3');
                              //$('#list-data').append(_template_end());
                              return false;
                     }
                    
                    $('#list-data').append(data.html);
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
  
 
 
  var $_quotaition_no = pa.param._quotaition_no;
  var $_time_strart = pa.param._time_strart;
  var $_time_end = pa.param._time_end;
 
  var formData = new FormData();


  
   var data = {
                         quotaition_no:$_quotaition_no
                         ,time_strart : $_time_strart
                         ,time_end:$_time_end
                         ,page:page
                         ,_token:config._token
                    };
                    
     var recursiveEncoded = $.param( data );      

  jQuery.ajax({
       
    type: 'GET',
    url: config.routes._searchdata,
    async: true,
    cache: false,
    data: data,
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
       
      $('#parentdata #view-loading-data #loading-data').remove();

      if (data.status == 'full') {
               $('#type-data').val('3');
               //$('#list-data').append(_template_end());
               return false;
      }
      
      $('#list-data').append(data.html);
      
    },
    error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                     }
  });
}



 function isValidDate(dateString) {
     var regEx = /^\d{4}\/\d{2}\/\d{2}$/;
     return dateString.match(regEx) != null;
}
                                         
                                    
function _template_viewload(){
     var _temp = "<div id='loading-data' style='text-align: center;'>"
                         +" <img src='"+config.image._loading_data+"' width='70px'>"
                      +"</div>";
      return  _temp;   
}

function _template_end(){
     var _temp = "<div id='loading-data' style='text-align: center;'>"
                         +"<h3>End</h3>"
                      +"</div>";
      return  _temp;   
}

function pages(){
     
     var _page = 2;
     
     return {
        get page() {
               return _page;
        },
        set page(val) {
            _page = val;
         }
      } 
}

function _set_param($_quotaition_no, $_time_strart, $_time_end){
     var _param = {
               _quotaition_no:$_quotaition_no,
               _time_strart:$_time_strart,
               _time_end:$_time_end,
        }   
     return _param;
}


function params(){
     
      var _param = {
               _quotaition_no:'',
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

