@if(Session::has('error'))
<div class="alert alert-danger" role="alert">
   {{  Session::get('error') }}
</div>
@endif