
$(function() {
	bs_input_file(".input-file");
     
            update_table_height();   
            window.onresize = function(event) {
               update_table_height();
           };    
});


$(document).off("click", ".clear_input_search");
$(document).on("click", ".clear_input_search", function () {
               $('.start-date').val('');
               $('.end-date').val('');
});


$(document).off("click", ".search-date");
$(document).on("click", ".search-date", function () {
          
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
          
          
          var formData = new FormData();
          formData.append('time_start',$_time_strart);
          formData.append('time_end',$_time_end);
          formData.append("_token",config._token);
          
          $(".loader").show();
          
           jQuery.ajax({
                    type: 'POST',
                    url: config.routes._searchdata,
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
                         
                         $('#list-content').empty();
                         $('#list-content').html(data.html);
                    },
                   error: function (jqXHR, exception) {
                        
                         if(jqXHR.status == '401'){
                             var msg =  'Your session has expired.';
                             alert(msg);
                             location.reload();
                             return false;
                        }
                        
                        var msg = 'Import error! system error';
                        alert(msg);
                }
           });
          
          
});



$(document).off("click", "#import-fle");
$(document).on("click", "#import-fle", function () {
    
    if (!$("#product").is(":checked") && !$("#option").is(":checked") ) {
         alert('Please select Product or Option type !');
         return false;
    } 
     
     
    var formData = new FormData();
    
    var files = $('#file-import')[0].files[0];
    
    if(files == undefined){
         alert('Please choose a file !');
         return false;
    }
    var _type = '';
    
    if($("#product").is(":checked")){
         
            _type = $("#product").val();
            
    }
    
    if($("#option").is(":checked")){
         
           _type = $("#option").val();
           
    }
    
    formData.append('type',_type);
    formData.append('file',files);
    formData.append("_token",config._token);
    
    $(".loader").show();
    jQuery.ajax({
        type: 'POST',
        url: config.routes._upload,
        async: true,
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        complete: function () {
                    $(".loader").hide();
                     _reset_file_input();
        },
        success: function (data) {
        	
        	if(data.status == 'OK' )
        	{
                      alert(data.msg);    
        		$('#list-content').empty();
                       $('#list-content').html(data.html);
                       update_table_height();
        	}
        	if(data.status == 'NG')
        	{
        		alert(data.msg);
                           if(data.html != undefined){
                                  $('#list-content').empty();
                                  $('#list-content').html(data.html);
                                  update_table_height();
                           }
        	}
            if(data.status == 'auth')
            {
                alert(data.msg);
              
                if(data.key == 0){
                   window.location.reload();
                }
                $(".loader").hide();
                return false;
            }   
            if(data.status == 'err_column')
            {
                alert('There is an error with template of importing file. Template format is incorrect');
                return false;
            }
            if(data.status == 'err_data')
            {
              alert('Data import has error, please check downloaded log file');
              var param = "?path_file="+data.path_file;
              window.location.href = config.routes._downloadlog+param;
            }
        },
        error: function (jqXHR, exception) {
             
                    if(jqXHR.status == '401'){
                         var msg =  'Your session has expired.';
                         alert(msg);
                         location.reload();
                         return false;
                    }
                   
                    upload_status();
                    load_view_all_data();
                    update_table_height();
                    var msg = 'Import error! system error';
                    alert(msg);
                }
    });
});




$(document).off("click", "#download-file-import");
$(document).on("click", "#download-file-import", function () {
     
    var formData = new FormData();
    var $his_id = $(this).attr('his-id');
    
    formData.append('his_id',$his_id);
    formData.append('key_download',0);
    
    formData.append("_token",config._token);
    
    $(".loader").show();
    
    jQuery.ajax({
        type: 'POST',
        url: config.routes._checkdownload,
        async: true,
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        complete: function () {
                    $(".loader").hide();
        },
        success: function (data) {
             
               if(data.status == 'OK'){
                    var param = "?his_id="+data.his_id+"&key_download="+data.key_download;
                    window.location.href = config.routes._download+param
               }
               if(data.status == 'NG'){
                    var msg = 'File not exist!';
                    alert(msg);
               }
                if(data.status == 'auth')
               {
                   alert(data.msg);
               
                   if(data.key == 0){
                      window.location.reload();
                   }
                   $(".loader").hide();
                   return false;
               }   
               
               
        },
        error: function (jqXHR, exception) {
             
                   if(jqXHR.status == '401'){
                         var msg =  'Your session has expired.';
                         alert(msg);
                         location.reload();
                         return false;
                    }
                    
                    var msg = 'Download error!';
                    alert(msg);
                }
    });
    
});

$(document).off("click", "#download-filelog-import");
$(document).on("click", "#download-filelog-import", function () {
     
    var formData = new FormData();
    var $his_id = $(this).attr('his-id');
    
    formData.append('his_id',$his_id);
    formData.append('key_download',1);
    
    formData.append("_token",config._token);
    
    $(".loader").show();
    
    jQuery.ajax({
        type: 'POST',
        url: config.routes._checkdownload,
        async: true,
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        complete: function () {
                    $(".loader").hide();
        },
        success: function (data) {
               if(data.status == 'OK'){
                    var param = "?his_id="+data.his_id+"&key_download="+data.key_download;
                    window.location.href = config.routes._download+param
               }
               if(data.status == 'NG'){
                    var msg = 'File not exist!';
                    alert(msg);
               }
                if(data.status == 'auth')
               {
                   alert(data.msg);
                   
                   if(data.key == 0){
                      window.location.reload();
                   }
                   $(".loader").hide();
                   return false;
                 }   
               
        },
        error: function (jqXHR, exception) {
             
                    if(jqXHR.status == '401'){
                         var msg =  'Your session has expired.';
                         alert(msg);
                         location.reload();
                         return false;
                    }
                    
                    var msg = 'Download error!';
                    alert(msg);
                }
    });
    
});




function bs_input_file($element) {
	$($element).before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' id='file-import' class='input-ghost' style='visibility:hidden; height:0'>");
				element.attr("name",$(this).attr("name"));
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file').prev().click();
					return false;
				});
				return element;
			}
		}
	);
}

function update_table_height() {
        var box = $("#parentdata");
        var window_h_margin = 356;
        var window_h = $('#content-body').height();
        var set_h = window_h - window_h_margin;
        box.height(set_h);
  }
  
  function upload_status() {
       
     var formData = new FormData();  
     
     formData.append("_token",config._token);
     jQuery.ajax({
        type: 'POST',
        url: config.routes._uploadstatus,
        async: false,
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        complete: function () {
                   
        }

    });
  }
  
  function load_view_all_data() {
       
     var formData = new FormData();  
     
     formData.append("_token",config._token);
     jQuery.ajax({
        type: 'POST',
        url: config.routes._viewalldata,
        async: false,
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
                   $('#list-content').empty();
                    $('#list-content').html(data.html);
        }

    });
}
function _reset_file_input(){
     $('#file-import').val('');
     $('#fileInput').val('');
     $('input[name="select-option"]').prop('checked',false);
     
}


function isValidDate(dateString) {
     var regEx = /^\d{4}\/\d{2}\/\d{2}$/;
     return dateString.match(regEx) != null;
}