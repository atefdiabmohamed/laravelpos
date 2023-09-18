@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<div class="row">
   <div class="col-md-4">
      <div class="form-group">
         <label>   بيانات الاصناف</label>
         <select  id="item_code_add" class="form-control select2" style="width: 100%;">
            <option value="">اختر الصنف</option>
            @if (@isset($item_cards) && !@empty($item_cards))
            @foreach ($item_cards as $info )
            <option data-type="{{ $info->item_type }}"   value="{{ $info->item_code }}"> {{ $info->name }} - {{ $info->barcode }} </option>
            @endforeach
            @endif
         </select>
         @error('suuplier_code')
         <span class="text-danger">{{ $message }}</span>
         @enderror
      </div>
   </div>
   <div class="col-md-4  relatied_to_itemCard" style="display: none;" id="UomDivAdd">
   </div>
   <div class="col-md-4 relatied_to_itemCard" style="display: none;">
      <div class="form-group">
         <label> الكمية المستلمة</label>
         <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="quantity_add" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-4 relatied_to_itemCard" style="display: none;">
      <div class="form-group">
         <label>  سعر الوحدة</label>
         <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="price_add" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-4 relatied_to_date" style="display: none;">
      <div class="form-group">
         <label>   تاريخ الانتاج</label>
         <input type="date"    id="production_date" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-4 relatied_to_date" style="display: none;">
      <div class="form-group">
         <label>   تاريخ انتهاء الصلاحية</label>
         <input type="date"    id="expire_date" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-4 relatied_to_itemCard" style="display: none;">
      <div class="form-group">
         <label>   الاجمالي</label>
         <input   readonly  id="total_add" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
      </div>
   </div>
   <div class="col-md-12">
      <div class="form-group text-center">
         <button type="button" class="btn btn-sm btn-danger" id="AddToBill">اضف للفاتورة</button>
         <p  id="AddEventMessage"></p>
      </div>
   </div>
</div>
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
@endsection