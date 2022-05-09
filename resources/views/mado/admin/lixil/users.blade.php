@extends('mado.admin.lixil.template-user')
@section('title', 'User management')



@section('main')
<div class="container">
<input type="text" id="username" style="width:0;height:0;visibility:hidden;position:absolute;left:0;top:0" />
<input type="password" style="width:0;height:0;visibility:hidden;position:absolute;left:0;top:0" />
    <div class="main" id="content-body" style="height: calc(100vh - 235px);">
            <h2 class="t-center" style="margin-top: 50px;font-size: xx-large;">List of User operations</h2>
            @if(Auth::user()->admin ==1)
           <div style="padding-top: 15px;text-align: center;">
               <input id="btnSave" type="button" value="Save"/>
           </div>
            @endif
        @include('mado.admin.lixil.users.listuserheader')
        <div style="overflow-y:scroll;" id="parentdata">
            <div  id="ListUser">
                @include('mado.admin.lixil.users.listuser')
            </div>
            @if(Auth::user()->admin ==1)
            <div style="float: left;padding-bottom: 40px;">
                <input class="btnAdd" id="btnAdd" type="button" value="+"/>
            </div>
            @endif
        </div>
      

       @if(Auth::user()->isAdmin())
       <center class="mt-5"><a data-href="{{ route('admin.lixil') }}" class=" rendect-page btn-back">Back</a></center>
       @else
       <center class="mt-5"><a data-href=" {{ route('admin.shop',[Auth::user()->shop->id]) }}" class="rendect-page  btn-back">Back</a></center>
       @endif
      
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
                <select  class="inputdata"  name="groupname"  >
                    @foreach($Companies as $cp)
                    <option value="{{$cp->groupname}}"  >{{ $cp->groupname}}</option>
                    @endforeach
                </select>
            </td>
            <td><input  class="inputdata" name="status" type="checkbox"  checked="checked"  /></td>
            <td class="">
                <select  class="inputdata"  name="role">
                    <option value="1">Admin</option>
                    <option value="0" selected="selected">User</option>
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
    
    @if(Auth::user()->isAdmin())
    // global app configuration object
    var config = {
        routes: {
             _deleteUser: '{{ route("admin.lixil.users.deleteuser") }}'
            ,_saveUser:'{{ route("admin.lixil.users.saveusers") }}'
            ,_changePass:'{{ route("admin.lixil.users.changepass") }}'
        },
        _token:"{{ csrf_token() }}",
        _auth:1
    };
    @endif
    
    @if(!Auth::user()->isAdmin())
    // global app configuration object
    var config = {
        routes: {
            _saveUser:'{{ route("admin.shop.users.saveusershop",Auth::user()->shop_id) }}'
            ,_changePass:'{{ route("admin.shop.users.changepassshop",Auth::user()->shop_id) }}'
        },
        _token:"{{ csrf_token() }}",
        _auth:0
    };
    @endif
    
</script>
<script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
<script src="{{asset('js/users.js')}}"></script>

<script>
    @if(Auth::user()->isAdmin())
          var _link_check_auth_login = '{{ route(".checkuserloginadmin") }}';
    @endif
    
    @if(!Auth::user()->isAdmin())
         var _link_check_auth_login = '{{ route(".checkuserlogin") }}';
    @endif
</script>
<script src="{{asset('tostem/common/js/tostem_admin.js')}}" ></script>
@endsection

@include('mado.admin.lixil.users.changepass')

@endsection