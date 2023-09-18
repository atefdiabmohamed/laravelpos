@if (@isset($permission_roles_main_menus) && !@empty($permission_roles_main_menus) )
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<form action="{{ route('admin.permission_roles.add_permission_roles_sub_menu',$permission_roles_main_menus['id']) }}" method="post" >
@csrf
      <div class="form-group">
         <label>   بيانات القوائم الفرعية</label>
         <select name="permission_sub_menues_id[]" multiple id="permission_sub_menues_id" class="form-control select2 ">
            <option value="">اختر القائمة الفرعية </option>
            @if (@isset($permission_sub_menues) && !@empty($permission_sub_menues))
            @foreach ($permission_sub_menues as $info )
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

