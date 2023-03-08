@if(!@empty($parent_pill_data) )
@if($parent_pill_data['is_closed']==0)
@if(!@empty($item_data_detials))
<form action="{{ route('admin.stores_inventory.edit_item_details',['id'=>$item_data_detials['id'],'id_parent'=>$parent_pill_data['id']]) }}" method="post" >
   @csrf
   <div class="row">
      <div class="col-md-4 " >
         <div class="form-group">
            <label>   الكمية الفعلية بالباتش</label>
            <input   readonly   id="old_quantity_edit" class="form-control"  value="{{ $item_data_detials['old_quantity']*1 }}"    >
         </div>
      </div>
      <div class="col-md-4 " >
         <div class="form-group">
            <label>   الكمية الفعلية الدفترية بالجرد</label>
            <input   oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="new_quantity_edit"   id="new_quantity_edit" class="form-control"  value="{{ $item_data_detials['new_quantity']*1 }}"    >
         </div>
      </div>
      <div class="col-md-4 ">
         <div class="form-group">
            <label>   ملاحظات - سبب النقص او الزيادة</label>
            <textarea   id="notes_edit" name="notes_edit" class="form-control"   >{{ $item_data_detials['notes']}}</textarea>
         </div>
      </div>
      <div class="col-md-12">
         <div class="form-group text-center">
            <button   type="submit" class="btn btn-sm btn-danger" id="EditDetailsItem">تعديل الباتش</button>
         </div>
      </div>
   </div>
</form>
@else
<div class="alert alert-danger">
   عفوا غير قادر الي الوصول للبيانات المطلوبة
</div>
@endif
@else
<div class="alert alert-danger">
   عفوا لايمكت تحديث فاتورة معتمدة ومؤرشفة
</div>
@endif
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif