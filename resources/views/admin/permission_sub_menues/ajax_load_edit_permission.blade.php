@if (@isset($data) && !@empty($data))

<div class="form-group">
   <label>اسم   الصلاحية</label>
   <input name="name_edit" id="name_edit" class="form-control" value="{{ $data['name'] }}"   >
   <div class="form-group" style="text-align: center; padding-top: 10px;">
      <button type="submit" data-id="{{ $data['id'] }}" id="do_edit_sub_permission_btn" class="btn btn-primary btn-sm">حفظ التعديلات</button>
      </div>

   @else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>

@endif