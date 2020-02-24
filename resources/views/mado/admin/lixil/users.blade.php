@extends('mado.admin.lixil.template-user')
@section('title', 'User management')



@section('main')
<div class="container">
<input type="text" id="username" style="width:0;height:0;visibility:hidden;position:absolute;left:0;top:0" />
<input type="password" style="width:0;height:0;visibility:hidden;position:absolute;left:0;top:0" />
    <div class="main" style="height: calc(100vh - 185px);">
         
           <div style="padding-top: 15px;text-align: center;">
               <input id="btnSave" type="button" value="Save"/>
           </div>
        
        @include('mado.admin.lixil.users.listuserheader')
        <div style="overflow-y:scroll; height: 450px;" id="parentdata">
            <div  id="ListUser">
                @include('mado.admin.lixil.users.listuser')
            </div>
            @if(Auth::user()->admin ==1)
            <div style="float: left;padding-bottom: 40px;">
                <input class="btnAdd" id="btnAdd" type="button" value="+"/>
            </div>
            @endif
        </div>
      



    </div>

</div>
<div style="display: none;" id="rowitem">
    <table id="tablerowadd">
        <tr id="0_0">
            <td>No</td>
            <td ><input class="inputdata" name="userid" type="text" value="" /></td>
            <td><input  class="inputdata"name="name" type="text" value=""/></td>
            <td><input  class="inputdata" name="email" type="text" value=""/></td>            
            <td><input  class="inputdata" name="phonenumber" type="text" value=""/></td>
            <td>
                <select  class="inputdata"  name="company"  >
                    @foreach($Companies as $cp)
                    <option value="{{$cp->groupname}}"  >{{ $cp->groupname}}</option>
                    @endforeach
                </select>
            </td>
            <td><input  class="inputdata" name="status" type="checkbox"  checked="checked"  /></td>
            <td class="">
                <select  class="inputdata"  name="role">
                    <option value="1">Admin</option>
                    <option value="0">User</option>
                </select>
            </td>

            <td><a href="#" class="btnDel" id=""  >Delete</a></td>
            <td></td>

        </tr>
    </table>

</div>
 <div class="loader">
        	<div class="spinner-border" role="status" id="Saving">
        		<span class="sr-only">Saving...</span>
        	</div>
 </div>
@section('script')


<script>
    
    @if(Auth::user()->isSuperAdmin())
    // global app configuration object
    var config = {
        routes: {
             _deleteUser: '{{ route("admin.lixil.users.deleteuser") }}'
            ,_saveUser:'{{ route("admin.lixil.users.saveusers") }}'
            ,_changePass:'{{ route("admin.lixil.users.changepass") }}'
        },
        _token:"{{ csrf_token() }}"
    };
    @endif
    
    @if(!Auth::user()->isSuperAdmin())
    // global app configuration object
    var config = {
        routes: {
            _saveUser:'{{ route("admin.shop.users.saveusershop",Auth::user()->shop_id) }}'
            ,_changePass:'{{ route("admin.shop.users.changepassshop",Auth::user()->shop_id) }}'
        },
        _token:"{{ csrf_token() }}"
    };
    @endif
    
</script>
<script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
<script src="{{asset('js/users.js')}}"></script>
@endsection

@include('mado.admin.lixil.users.changepass')

@endsection