@extends("tostem.admin.template")
@section('head')
    @parent
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('common/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('tostem/admin/pmaintenance/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('tostem/admin/pmaintenance/css/pmaintenance.css') }}">

<title>Price Maintenance</title>
<script src="{{ asset('js/jquery-2.2.4.min.js') }}"></script>
<meta name="robots" content="noindex,nofollow" >
    <style>
        .test
    </style>
@endsection

@section('content')
<div id="content-body" style="height: calc(100vh - 185px);">
     <div class="content_pmaintenance">
          @include('tostem.admin.pmaintenance.module-content.module-content')
     </div>
</div>
 <div class="loader">
        	<div class="spinner-border" role="status" id="Saving">
        		<span class="sr-only">Saving...</span>
        	</div>
 </div>
@endsection

@section('script')
<script src="{{asset('tostem/admin/pmaintenance/js/jquery-ui.js')}}"></script>
<script src="{{asset('tostem/admin/pmaintenance/js/calendar.js')}}"></script>
<script src="{{asset('tostem/admin/pmaintenance/js/pmaintenance.js')}}"></script>


  <script>
    $('#loading').remove();   
    var config = {
        routes: {
            _upload:'{{ route("admin.lixil.price-maintenance.upload") }}',
            _checkdownload:'{{ route("admin.lixil.price-maintenance.checkdownload") }}',
            _download:'{{ route("admin.lixil.price-maintenance.download") }}',
            _searchdata:'{{ route("admin.lixil.price-maintenance.searchdata") }}',
            _uploadstatus:'{{ route("admin.lixil.price-maintenance.uploadstatus") }}',
            _viewalldata:'{{ route("admin.lixil.price-maintenance.viewalldata") }}',
            _downloadlog:'{{ route("admin.lixil.price-maintenance.downloadlog") }}',
        },
        _token:"{{ csrf_token() }}"
    };
   
</script>

 <script>
@if(Auth::user()->isAdmin())
          var _link_check_auth_login = '{{ route(".checkuserloginadmin") }}';
    @endif
    
    @if(!Auth::user()->isAdmin())
         var _link_check_auth_login = '{{ route(".checkuserlogin") }}';
    @endif
</script>


<script src="{{asset('tostem/common/js/tostem_admin.js')}}" ></script>

    @parent
@endsection
