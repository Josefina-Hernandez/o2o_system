<form autocomplete="off">   
    <table id="tUsers" >
        <colgroup>
            <col style="width: 3%;">              
            <col style="width: 8%;">
            <col style="width: 8%;">
            <col style="width: 26%;">
            <col style="width: 8%;">
            <col style="width: 10%;">
            <col style="width: 5%;">
            <col style="width: 8%;">
            <col style="width: 5%;">
            <col style="width: *;"> 
        </colgroup>
        <tbody>
            <?php $NO = 0; ?>
            @foreach ($Users as $row)
            <?php $NO++; ?>
            <tr id="{{  $NO }}_{{$row->id}}">
                <td>
                    {{  $NO }}
                </td>
                
                <td class="@if(Auth::user()->admin !=1 || Auth::user()->id == $row->id) col-userid @endif">
                     <input  class="inputdata" name="userid" type="text" value="{{$row->login_id}}"  @if(Auth::user()->admin !=1 || Auth::user()->id == $row->id) disabled @endif />
                </td>
                @if(Auth::user()->admin ==1)

                <td class="">
                     <input   class="inputdata"name="name" type="text" value="{{$row->name}}" />
                </td>
               
                <td class="">
                     <input  class="inputdata" name="email" type="text" value="{{$row->email}}"/>
                </td>
                
                <td class="">
                     <input  class="inputdata" name="phonenumber" type="text" value="{{$row->phonenumber}}"/>
                </td>
                
                @else
                
                 <td class="col-userid">
                     <input   class="inputdata"name="name" type="text" value="{{$row->name}}" disabled />
                </td>
               
                <td class="col-userid">
                     <input  class="inputdata" name="email" type="text" value="{{$row->email}}" disabled/>
                </td>
                
                <td class="col-userid">
                     <input  class="inputdata" name="phonenumber" type="text" value="{{$row->phonenumber}}" disabled/>
                </td>
                
                 @endif
                <td class="@if(Auth::user()->admin !=1 || Auth::user()->id == $row->id) col-userid @endif">
                @if(Auth::user()->id != $row->id)
                 <select  class="inputdata"  name="company"  @if(Auth::user()->admin !=1) disabled @endif  >
                      @foreach($Companies as $cp)
                        <option value="{{$cp->groupname}}" @if($row->company == $cp->groupname) selected @endif >{{ $cp->groupname}}</option>
                      @endforeach
                  </select>
                @endif
                </td>
                
                @if(Auth::user()->admin ==1)
                <td class="">
                     <input  class="inputdata" name="status" type="checkbox"  @if ($row->status) checked="checked"  @endif value="{{$row->status}}">
                </td>
                @else
                <td class="col-userid">
                     <input  class="inputdata" name="status" type="checkbox" disabled  @if ($row->status) checked="checked"  @endif value="{{$row->status}}" >
                </td>
                 @endif
                <td class="@if($Role != 1) col-userid @endif">
                @if($Role == 1)
                    <select  class="inputdata"  name="role"  @if(Auth::user()->admin !=1) disabled @endif  >
                        <option value="1" @if ($row->admin == 1) selected @endif >Admin</option>
                        <option value="0" @if ($row->admin == 0) selected @endif >User</option>
                    </select>
                @endif
                </td>

                <td class="@if(Auth::user()->admin !=1  || Auth::user()->id == $row->id) col-userid @endif">
                     @if(Auth::user()->admin ==1 && Auth::user()->id != $row->id)
                     <a href="#" class="btnDel" id="{{$row->id}}" @if ($row->login_id=="admin") style="display:none"  @endif >Delete</a>
                     @endif
                </td>
                
                <td>
                     <a href="#" class="btnChangePass" data-id="{{$row->id}}" user-id="{{$row->login_id}}">Change password</a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
    <input  id="MaxNO" type="hidden" value="{{$NO}}"/>
    <input  id="IdEdit" type="hidden" value=""/>
</form>
