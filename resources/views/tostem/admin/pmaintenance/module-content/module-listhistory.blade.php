<table id="content-table" >
     <colgroup>
                <col style="width: 4%;">              
                <col style="width: 20%;">
                <col style="width: 20%;">
                <col style="width: 10%;">
                <col style="width: 10%;">
                <col style="width: 18%;">
                <col style="width: *;">     
            </colgroup>
    <tbody>
        @if($_all_historys->count() > 0)
               @foreach($_all_historys as $k => $v)
                    <tr>
                        <td >{{$k+1}}</td>            
                        <td>{{$v->created_at}}</td>
                        <td>{{$v->filename}}</td>
                        <td>{{$v->login_id}}</td>
                        <td>
                             
                         
                             @if($v->status == 9)
                             Complete
                             @endif
                             @if($v->status == 6)
                             Error
                             @endif
                             @if($v->status == 0)
                             Start
                             @endif
                             
                        </td>
                        <td><span id="download-file-import" his-id="{{$v->id}}">・・・</span></td>
                        <td><span id="download-filelog-import" his-id="{{$v->id}}">・・・</span></td>
                    </tr>
               @endforeach
        @endif
    </tbody>
</table>

