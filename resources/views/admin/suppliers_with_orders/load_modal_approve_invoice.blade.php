@if (@isset($data) && !@empty($data))
@if($data['is_approved']==0)
@if($counterDetails>0)
<form action="{{ route("admin.suppliers_orders.do_approve",$data['auto_serial']) }}" method="post">
@csrf
<div class="row">
   <div class="col-md-6">
      <div class="form-group">
         <label>اجمالي الاصناف بالفاتورة </label>
         <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="total_cost_items"  id="total_cost_items" 
            class="form-control"  value="{{ $data['total_cost_items']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>  نسبة ضريبة القيمة المضافة </label>
         <input  oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="tax_percent"  id="tax_percent" 
            class="form-control"  value="{{ $data['tax_percent']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>  قيمة الضريبة  المضافة </label>
         <input readonly    id="tax_value" class="form-control"  name="tax_value" value="{{ $data['tax_value']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>  قيمة   الاجمالي قبل الخصم </label>
         <input readonly    id="total_befor_discount" name="total_befor_discount" class="form-control"  
            value="{{ $data['total_befor_discount']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>     نوع الخصم ان وجد </label>
         <select class="form-control" name="discount_type" id="discount_type">
            <option value="">لايوجد خصم</option>
            <option value="1" @if($data['discount_type']==1) selected @endif >    نسبة مئوية</option>
            <option value="2" @if($data['discount_type']==2) selected @endif > قيمة يدوي</option>
         </select>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>     نسبة  الخصم </label>
         <input @if($data['discount_type']=="" || $data['discount_type']==null) readonly @endif    oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="discount_percent"  id="discount_percent" class="form-control"  value="{{ $data['discount_percent']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>  قيمة   الخصم   </label>
         <input readonly  name="discount_value"   id="discount_value" class="form-control"  value="{{ $data['discount_value']*1 }}"  >
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label>     الاجمالي النهائي  بعد الخصم   </label>
         <input readonly name="total_cost"    id="total_cost" class="form-control"  value="{{ $data['total_cost']*1 }}"  >
      </div>
   </div>
</div>
<div class="row" id="shiftDiv">
   <div class="col-md-6">
      <div class="form-group">
         <label>    خزنة الصرف  </label>
         <select id="treasuries_id" name="treasuries_id" class="form-control">
            @if(!@empty($user_shift))
            <option selected value="{{ $user_shift['treasuries_id']  }}"> {{ $user_shift['name'] }} </option>
            @else
            <option value=""> عفوا لاتوجد خزنة لديك الان</option>
            @endif
         </select>
      </div>
   </div>
   <div class="col-md-6 > 
      <div class="form-group">
      <label>  الرصيد المتاح بالخزنة   </label>
      <input  readonly name="treasuries_balance" id="treasuries_balance" class="form-control" 
      @if(!@empty($user_shift))
      value="{{ $user_shift['balance']*1 }}" 
      @else
      value="0" 
      @endif
      >
   </div>
</div>
<div class="row">
   <div class="col-md-6">
      <div class="form-group">
         <label>     نوع الفاتورة   </label>
         <select class="form-control" name="pill_type" id="pill_type">
         <option value="1" @if($data['pill_type']==1) selected @endif >     كاش</option>
         <option value="2" @if($data['pill_type']==2) selected @endif >  اجل</option>
         </select>
      </div>
   </div>
   <div class="col-md-6 > 
      <div class="form-group">
      <label>    المدفوع للمورد الان   </label>
      <input   name="what_paid" id="what_paid" class="form-control"  @if($data['pill_type']==2)  value="0" @else readonly value="{{ $data['total_cost']*1 }}"   @endif  >
   </div>
   <div class="col-md-6 > 
      <div class="form-group">
      <label>    المتبقي للمورد    </label>
      <input readonly   name="what_remain" id="what_remain" class="form-control"  @if($data['pill_type']==2)  value="{{ $data['total_cost']*1 }}" @else value="0"   @endif  >
   </div>
   <div class="col-md-12 text-center" >
      <hr>
      <button type="submit" id="do_close_approve_invoice_now"  class="btn btn-sm btn-danger">  اعتماد وترحيل الان</button>
   </div>
</div>
</form>
@else
<div class="alert alert-danger">
   عفوا لايمكن اعتماد الفاتورة قبل  اضافة الأصناف عليها !!!
</div>
@endif
@else
<div class="alert alert-danger">
   عفوا لقد تم اعتماد هذه الفاتورة من قبل !!!
</div>
@endif
@else
<div class="alert alert-danger">
   عفوا لاتوجد بيانات لعرضها !!
</div>
@endif