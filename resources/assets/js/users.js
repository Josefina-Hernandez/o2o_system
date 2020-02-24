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
            var result = confirm("re you sure to delete?");
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
                        } else
                        {
                            alert("This user cannot be deleted");
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
        showModal(data_id, _user_id);
        
    });
    
    $(document).off("click", "#btnSave");
    $(document).on("click", "#btnSave", function () {
        var listId = $("#IdEdit").val();
        var arrListID = listId.split(",");
        var users = {
            user: []
        };
        var arrUserId = [];
        // var table = $('#tUsers');
        var bErr = false;
        $('#tUsers > tbody  > tr').each(function (i, row) {
            var $row = $(row);
            var noid = $row.attr('id');
            var arr = noid.split("_");
            var id = arr[1];
            var userid = $row.find('input[name="userid"]').val();
            if (userid != "")
            {
                if (arrUserId.indexOf(userid) != -1)
                {
                    alert("User ID " + userid + " is dupllicated");
                    bErr = true;
                    return false;
                }
                arrUserId.push(userid);
                if (arrListID.indexOf(id) != -1 || id == 0)
                {

                    var status = $row.find('input[name="status"]').prop('checked');
                    var email = $row.find('input[name="email"]').val();
                    var role = $row.find('select[name="role"]>option:selected').val();
                    var name = $row.find('input[name="name"]').val();
                    var phonenumber = $row.find('input[name="phonenumber"]').val();
                    var company = $row.find('select[name="company"]>option:selected').val(); // $row.find('input[name="company"]').val();
                      if(company==undefined)
                        company="";
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
                        "company": company,
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
                    } else
                    {
                        $("#ListUser").html(data);
                        alert("Saved successfully");
                       initEvent();
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = 'An error has occurred. Contact your system administrator.';
    //                if (jqXHR.status === 0) {
    //                    msg = 'Not connect.\n Verify Network.';
    //                } else if (jqXHR.status == 404) {
    //                    msg = 'Requested page not found. [404]';
    //                } else if (jqXHR.status == 500) {
    //                    msg = 'Internal Server Error [500].';
    //                } else if (exception === 'parsererror') {
    //                    msg = 'Requested JSON parse failed.';
    //                } else if (exception === 'timeout') {
    //                    msg = 'Time out error.';
    //                } else if (exception === 'abort') {
    //                    msg = 'Ajax request aborted.';
    //                } else {
    //                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
    //                }
                    alert(msg);
                }
            });
        }
        return false;
    });
    
   
    $(document).off("click", "._saveChangePass");
    $(document).on("click", "._saveChangePass", function () {    
        changePass();
    });
    
});
function update_table_height() {
        var box = $("#parentdata");
        var window_h_margin = 290;
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

function showModal(id, userid)
{
    $("#targetId").val(id);
    $("#targetuserid").val(userid);
    $("#oldpassword").val("");
    $("#newpassword").val("");
    $("#confirmpassword").val("");
    $('#ChangePassDialog').modal('show');
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
    if (password == "" || newpassword == "" || confirmpassword == "")
    {
        alert("Please enter your password.");
        return false;
    }
    if (newpassword != confirmpassword)
    {
        alert('Confirm Password" is incorrect.');
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
                hideModal();
            } else
            {
                alert("Cannot update password. Contact your Administrator for assistance.");
            }

        }
    });
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}