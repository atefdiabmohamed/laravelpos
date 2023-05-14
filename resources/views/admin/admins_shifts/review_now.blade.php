@if (@isset($checkExistsOpenShift) && !@empty($checkExistsOpenShift))
@if (@isset($admins_shifts_will_reviwed) && !@empty($admins_shifts_will_reviwed))

<form action="{{ route('admin.admin_shift.do_review_now',$admins_shifts_will_reviwed['id']) }}" method="post" >
   @csrf
   <div class="form-group">
      <label> اجمالي النقدية بهذا الشفت علي النظام </label>
      <input required  readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="money_should_deviled" id="money_should_deviled" class="form-control"  value="{{ $admins_shifts_will_reviwed['money_should_deviled']*1 }}"  >

      </div>
      <div class="form-group">
         <label> اجمالي النقدية الفعلية المستلمة يدويا بهذا الشفت </label>
         <input required   oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="what_realy_delivered" id="what_realy_delivered" class="form-control"  value="{{ $admins_shifts_will_reviwed['money_should_deviled']*1 }}"  >
   
         </div>
         <div class="form-group">
            <label> حالة الاستلام</label>
         <select name="money_state" id="money_state" class="form-control">
       
           <option selected value="0">متزن</option>
           <option value="1">يوجد عجز بالنقدية</option>
            <option value="2">يوجد زيادة بالنقدية</option>
         </select>
         </div>
         <div class="form-group" style="display: none;" id="money_state_valueDiv">
            <label id="money_state_valueLablel"></label>
            <input required id="money_state_value" name="money_state_value" readonly value="0" class="form-control" >
            </div>
   <div class="form-group text-center">
      <button type="submit" class="btn btn-primary btn-sm"> استلام النقدية الان</button>
      <a href="{{ route('admin.admin_shift.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
   </div>
</form>
@else
<div class="alert alert-danger">
 عفوا غير قادر علي الوصول الي بيانات هذا الشفت
</div>
@endif
@else
<div class="alert alert-danger">
 عفوا لايوجد شفت مفتوح لك حالياً
</div>
@endif