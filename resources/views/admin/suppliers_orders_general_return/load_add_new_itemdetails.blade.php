@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
<div class="row">
  <div class="col-md-4" >
     <div class="form-group">
        <label>    بيانات المخازن</label>
        <select name="store_id" id="store_id" class="form-control ">
           @if (@isset($stores) && !@empty($stores))
           @php $i=1;  @endphp
           @foreach ($stores as $info )
           <option @if($i==1) selected @endif value="{{ $info->id }}"> {{ $info->name }} </option>
           @php $i++;  @endphp
           @endforeach
           @else
           <option value=""> اختر المخزن  </option>
           @endif
        </select>
     </div>
  </div>
  <div class="col-md-4">
     <div class="form-group">
        <label>   بيانات الاصناف</label>
        <select  id="item_code" name="item_code" class="form-control select2" style="width: 100%;">
           <option value="">اختر الصنف</option>
           @if (@isset($item_cards) && !@empty($item_cards))
           @foreach ($item_cards as $info )
           <option data-type="{{ $info->item_type }}"   value="{{ $info->item_code }}"> {{ $info->name }} -  {{ $info->barcode }} </option>
           @endforeach
           @endif
        </select>
        @error('suuplier_code')
        <span class="text-danger">{{ $message }}</span>
        @enderror
     </div>
  </div>
  <div class="col-md-4  " style="display: none;" id="UomDiv">
  </div>
  <!--   باتشات الكميات بالمخازن-->
  <div class="col-md-8  " style="display: none;" id="inv_itemcard_batchesDiv">
  </div>
  <div class="col-md-4 relatied_to_itemCard" style="display: none;">
     <div class="form-group">
        <label>  سعر تكلفة الشراء بالباتش</label>
        <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="item_price" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
     </div>
  </div>
  <div class="col-md-4 relatied_to_itemCard" style="display: none;">
     <div class="form-group">
        <label> الكمية المرتجعة</label>
        <input   oninput="this.value=this.value.replace(/[^0-9]/g,'');"  id="item_quantity" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
     </div>
  </div>
  <div class="col-md-4 relatied_to_itemCard" style="display: none;">
     <div class="form-group">
        <label>   الاجمالي</label>
        <input   readonly  id="item_total" class="form-control"  value=""  oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
     </div>
  </div>
  <div class="col-md-2">
     <div class="form-group text-center">
        <button type="button" style="margin-top: 31px;" class="btn btn-sm btn-danger" id="AddItemToIvoiceDetailsActive">اضف للفاتورة</button>
     </div>
  </div>
  <p  id="AddEventMessage"></p>
</div>
</div>
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
@endsection