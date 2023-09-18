@if (@isset($permission_roles_sub_menu) && !@empty($permission_roles_sub_menu) )
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<form action="{{ route('admin.permission_roles.add_permission_roles_sub_menues_actions',$permission_roles_sub_menu['id']) }}" method="post" >
@csrf
      <div class="form-group">
         <label>   بيانات الصلاحيات المباشرة لهذه القائمة</label>
         <select name="permission_sub_menues_actions_id[]" multiple id="permission_sub_menues_actions_id" class="form-control select2 ">
            <option value="">اختر الصلاحيات  </option>
            @if (@isset($permission_sub_menues_actions) && !@empty($permission_sub_menues_actions))
            @foreach ($permission_sub_menues_actions as $info )
            <option  value="{{ $info->id }}"> {{ $info->name }} </option>
            @endforeach
            @endif
         </select>
      
      </div>
 
      <div class="form-group text-center">
         <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
      </div>
</form>

@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>

<script>
   //Initialize Select2 Elements
  
</script>

@endif

