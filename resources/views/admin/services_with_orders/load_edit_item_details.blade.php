@if(!@empty($parent_pill_data) )
@if($parent_pill_data['is_approved']==0)
@if(!@empty($item_data_detials))
<div class="row">
   <div class="col-md-4">
      <div class="form-group">
         <label>   بيانات الخدمات</label>
         <select  id="services_id_add" class="form-control select2" style="width: 100%;">
            <option value="">اختر الخدمة</option>
            @if (@isset($services) && !@empty($services))
            @foreach ($services as $info )
            <option  @if($item_data_detials['service_id']==$info->id) selected @endif  value="{{ $info->id }}"> {{ $info->name }} </option>
            @endforeach
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-4 " >
      <div class="form-group">
         <label>   الاجمالي</label>
         <input     id="total_add" class="form-control"  value="{{ $item_data_detials['total']*1 }}"  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-4 ">
      <div class="form-group">
         <label>   ملاحظات</label>
         <textarea   id="notes_add" class="form-control"   >{{ $item_data_detials['notes']}}</textarea>
      </div>
   </div>
   <div class="col-md-12">
      <div class="form-group text-center">
         <button  data-id="{{ $item_data_detials['id'] }}" type="button" class="btn btn-sm btn-danger" id="EditDetailsItem">تعديل الخدمة</button>
      </div>
   </div>
</div>
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