@if($_all_historys)

@php 
$i = ($_all_historys->currentpage()-1)* $_all_historys->perpage() + 1;
@endphp     

               @foreach($_all_historys as $k => $v)
                    <tr>
                        <td >{{$i++}}</td>
                        <td>{{$v->quotation_session}}</td>
                        <td>{{$v->login_id}}</td>
                        <td>{{$v->quotation_date}}</td>
                        <td> {{$v->quotation_no}}</td>
                        <td>{{$v->design}}</td>
                        <td>{{$v->button_click}}</td>
                    </tr>
               @endforeach
          
@endif


