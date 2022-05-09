require('./bootstrap');
$(document).ready(function () {
    update_table_height();
    initEvent();
    
    window.onresize = function(event) {
        update_table_height();
    };
    
    $(document).off("click", "#btnAdd");
    $(document).on("click", "#btnAdd", function () {
        var No = parseInt($("#MaxNO").val()) + 1;
        var table = $('#tUsers');
        var tr = $("#tablerowadd tr").clone();
        var cells = tr.children();
        $(cells[0]).text(No);
        table.append(tr); 
       $("#MaxNO").val(No);
        //Scroll to bottom
        var objDiv = document.getElementById("parentdata");
        objDiv.scrollTop = objDiv.scrollHeight;
        return false;
    });
    $(document).off("click", ".btnDel");
    $(document).on("click", ".btnDel", function () {
        var id = $(this).attr('id');
        var tr = $(this).parent().parent();
        if (id != 0)
        {
            var result = confirm("Are you sure to delete?");
            if (result) {
                //Logic to delete the item
                $.ajax({
                    type: 'post',
                    url: config.routes._deleteUser,
                    dataType: 'text',
                    async: true,
                    cache: false,
                    data: {
                        "_token": config._token,
                        "id": id
                    },
                    success: function (data) {

                        if (data == 0)
                        {
                            tr.remove();
                            alert("Deleted Successfully");
                        } 
                        else if(data.status == 'auth'){
                             alert(data.msg);
                             if(data.key == 0){
                                window.location.reload();
                             }
                             $(".loader").hide();
                             return false;
                        } 
                        else
                        {
                            alert("This user cannot be deleted");
                        }

                    },
                     error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                     }
                });
            }
        } else
        {
            tr.remove();
        }

        return false;
    });
    
    $(document).off("click", ".btnChangePass");
    $(document).on("click", ".btnChangePass", function () {
        
        var data_id = $(this).attr('data-id');
        var _user_id = $(this).attr('user-id');
        var type_user = $(this).attr('type_user');
        showModal(data_id, _user_id,type_user);
        
    });
    
    $(document).off("click", "#btnSave");
    $(document).on("click", "#btnSave", function () {
        var listId = $("#IdEdit").val();
        var arrListID = listId.split(",");
        var users = {
            user: []
        };
        var arrUserId = [];
        var arrUserEmail = []; 
        // var table = $('#tUsers');
        var bErr = false;
        $('#tUsers > tbody  > tr').each(function (i, row) {
            var $row = $(row);
            var noid = $row.attr('id');
            var arr = noid.split("_");
            var id = arr[1];
            var userid = $row.find('input[name="userid"]').val().trim();
            var email = $row.find('input[name="email"]').val().trim();
            
            if (userid != "")
            {
                 
                if (arrUserId.indexOf(userid) != -1)
                {
                    alert("User ID " + userid + " is dupllicated");
                    bErr = true;
                    return false;
                }
                if(userid != 'lixil' &&  userid != 'employee' ){
                           if(email == "" ){

                                   /*alert("Email of  user id :  " + userid + " is required");
                                   bErr = true;
                                   return false;*/

                            }else{
                                   if (arrUserEmail.indexOf(email) != -1)
                                   {

                                      alert("Email " + email + " is dupllicated");
                                      bErr = true;
                                      return false;

                                   }
                              }
                }

                arrUserId.push(userid);
                arrUserEmail.push(email);
                
                if (arrListID.indexOf(id) != -1 || id == 0)
                {

                    var status = $row.find('input[name="status"]').prop('checked');
                    
                    var role = $row.find('select[name="role"]>option:selected').val();
                    var name = $row.find('input[name="name"]').val();
                    var phonenumber = $row.find('input[name="phonenumber"]').val();
                    var groupname = $row.find('select[name="groupname"]>option:selected').val(); // $row.find('input[name="company"]').val();
                      if(groupname==undefined)
                        groupname="";
                    var arrEmail = email.split(",");
                    for (var i = 0; i < arrEmail.length; i++)
                    {
                        if (email != "" && validateEmail(arrEmail[i].trim()) == false)
                        {
                            alert("This email is invalid: " + email);
                            bErr = true;
                            return false;
                        }
                    }
                    users.user.push({
                        "id": id,
                        "userid": userid,
                        "email": email,
                        "name": name,
                        "phonenumber": phonenumber,
                        "groupname": groupname,
                        "status": status,
                        "role": role
                    });
                }
            }
        });
        if (bErr == false)
        {
            $(".loader").show();
            $.ajax({
                type: 'post',
                url: config.routes._saveUser,
                contentType: "json",
                processData: false,
                async: true,
                cache: false,
                data: JSON.stringify(users),
                headers: {'X-CSRF-TOKEN': config._token},
                complete: function () {
                    $(".loader").hide();
                },
                success: function (data) {
                    if (data == 1)
                    {
                        alert("User ID is duplicated.");
                        return false;
                    } else if(data.status == 'auth')
                     {
                             alert(data.msg);
                             if(data.key == 0){
                                window.location.reload();
                             }
                             $(".loader").hide();
                             return false;
                     } 
                    else
                    {
                        $("#ListUser").html(data);
                        alert("Saved successfully");
                       initEvent();
                    }
                   
                },
                 error: function (jqXHR, exception) {
                         if(jqXHR.status == '401'){
                               alert("Your session has expired.");
                               location.reload();
                         }
                   }
            });
        }
        return false;
    });
    
   
    $(document).off("click", "._saveChangePass");
    $(document).on("click", "._saveChangePass", function () {    
        changePass();
    });
    
    
    
    $(document).on("change paste", ".inputdata.user_id_login", function () {    
               $(this).val($(this).val().trim());
    });

    
});
function update_table_height() {
        var box = $("#parentdata");
        var window_h_margin = 432;
        var window_h = $(window).height();
        var set_h = window_h - window_h_margin;
        box.height(set_h);
    }
function initEvent()
{
    $(".inputdata").on("change paste keyup", function () {
        var tr = $(this).parent().parent();
        var noid = tr.attr('id');
        var arr = noid.split("_");
        var id = arr[1];
        var listId = $("#IdEdit").val() + "," + id;
        $("#IdEdit").val(listId);
    });
}

function showModal(id, userid,type_user)
{
    $("#targetId").val(id);
    $("#targetuserid").val(userid);
    $("#oldpassword").val("");
    $("#newpassword").val("");
    $("#confirmpassword").val("");
    $('#ChangePassDialog').modal('show');
    
    if(config._auth == 1){
         
          if(type_user == 0){
               
               $('#confim_p').hide();
               $('#ChangePassDialog #type_user_update').val('0');
               
          }else{
               $('#confim_p').show();
               $('#ChangePassDialog #type_user_update').val('1');
          }
          
    }else{
         $('#confim_p').show();
         $('#ChangePassDialog #type_user_update').val('1');
    }
}
function hideModal()
{
    $('#ChangePassDialog').modal('hide');
}
function changePass()
{
    var id = $("#targetId").val();
    var password = $("#oldpassword").val();
    var newpassword = $("#newpassword").val();
    var confirmpassword = $("#confirmpassword").val();
    var type_user = $('#ChangePassDialog #type_user_update').val;
    
     if(config._auth == 1){
          
                    if(type_user == 0){
                         
                           if (password == "" || newpassword == "" || confirmpassword == "")
                               {
                                   alert("Please enter your password.");
                                   return false;
                               }
                               
                    }else{
                         
                          if (newpassword == "" || confirmpassword == "")
                               {
                                   alert("Please enter your password.");
                                   return false;
                               }
                    }
     }else{
            if (password == "" || newpassword == "" || confirmpassword == "")
             {
                    alert("Please enter your password.");
                    return false;
               }
     }
   
    
    if (newpassword != confirmpassword)
    {
        alert('"Confirm Password" is incorrect.');
        return false;
    }
    $.ajax({
        type: 'post',
        url: config.routes._changePass,
        dataType: 'text',
        async: true,
        cache: false,
        data: {
            "_token": config._token,
            "id": id,
            "password": password,
            "newpassword": newpassword
        },
        success: function (data) {

            if (data == 0)
            {
                alert("Saved successfully");
                hideModal();
            }
            else if(data.status == 'auth'){
                    alert(data.msg);
                    if(data.key == 0){
                       window.location.reload();
                    }
                    $(".loader").hide();
                    return false;
            }
            else
            {
                alert("Cannot update password. Contact your Administrator for assistance.");
            }

        },
        error: function (jqXHR, exception) {
             if(jqXHR.status == '401'){
                   alert("Your session has expired.");
                   location.reload();
             }
        }
        
    });
}




function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}