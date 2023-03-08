<div class="form-group">
  <label>   بيانات العملاء
  (<a id="load_add_new_customer" title=" اضافة عميل جديد " href="#">جديد <i   class="fa fa-plus-circle  "></i> </a>) 
  </label>
  <input type="text" class="form-control" id="searchbytextforcustomer" placeholder="اسم العميل - كود العميل">
  <div id="searchbytextforcustomerDiv">
     <select name="customer_code" id="customer_code" class="form-control select2">
        <option value=""> لايوجد عميل</option>
        @if (@isset($customers) && !@empty($customers))
        @foreach ($customers as $info )
        <option selected  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
        @endforeach
        @endif
     </select>
  </div>
</div>