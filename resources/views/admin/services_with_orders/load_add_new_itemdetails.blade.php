<div class="row">
  <div class="col-md-4">
     <div class="form-group">
        <label>   بيانات الخدمات</label>
        <select  id="services_id_add" class="form-control select2" style="width: 100%;">
           <option value="">اختر الخدمة</option>
           @if (@isset($services) && !@empty($services))
           @foreach ($services as $info )
           <option   value="{{ $info->id }}"> {{ $info->name }} </option>
           @endforeach
           @endif
        </select>
        @error('suuplier_code')
        <span class="text-danger">{{ $message }}</span>
        @enderror
     </div>
  </div>
  <div class="col-md-4 " >
     <div class="form-group">
        <label>   الاجمالي</label>
        <input     id="total_add" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
     </div>
  </div>
  <div class="col-md-4 ">
     <div class="form-group">
        <label>   ملاحظات</label>
        <textarea   id="notes_add" class="form-control"   ></textarea>
     </div>
  </div>
  <div class="col-md-12">
     <div class="form-group text-center">
        <button type="button" class="btn btn-sm btn-danger" id="AddToBill">اضف للفاتورة</button>
     </div>
  </div>
</div>