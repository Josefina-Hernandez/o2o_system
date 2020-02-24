<div id="ChangePassDialog" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">  
            <div class="modal-header">
               	Change password                                    
            </div>  
            <div class="modal-body" width="90%">

                <input  type="hidden"   id="targetId" />
                <table style="width: 100%;">
                    <tr>
                    	<td class="title">Current password </td>
                    	<td><div class="form-group"><input autocomplete="off"  id="oldpassword" type="password" class="form-control" /></div></td>
                    </tr>
                    <tr>
                    	<td class="title">User ID </td>
                    	<td><div class="form-group"><input disabled  id="targetuserid" type="text" class="form-control" /></div></td>
                    </tr>

                    <tr>
                    	<td class="title">New password </td>
                    	<td><div class="form-group"><input  autocomplete="off"  id="newpassword" type="password" class="form-control" /></div></td>
                    </tr>
                    <tr>
                    	<td class="title">Confirm password</td>
                    	<td><div class="form-group"><input  autocomplete="off"   id="confirmpassword" type="password" class="form-control" /></div></td>
                    </tr>

                </table>              

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary _saveChangePass">Save</button>	

            </div>
        </div>       
    </div>
</div> 