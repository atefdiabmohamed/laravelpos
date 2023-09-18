@if(!@empty($parent_pill_data) and !@empty($data) )
<form action="{{ route('admin.inv_stores_transfer_incoming.do_cancel_one_details',["id"=>
   $data['id'],"id_parent"=>$parent_pill_data['id'] ]) }}" method="post" >
   @csrf
   <div class="form-group">
      <label>    سبب الألغاء</label>
      <textarea name="canceld_cause" id="canceld_cause"  autofocus required  class="form-control"   ></textarea>
   </div>
   <div class="form-group text-center">
      <button type="submit" class="btn btn-danger btn-sm" name="submit">تأكيد الالغاء</button>
   </div>
</form>
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif