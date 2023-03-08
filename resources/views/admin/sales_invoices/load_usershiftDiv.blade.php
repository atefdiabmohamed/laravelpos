<div class="col-md-3">
  <div class="form-group">
     <label>    خزنة التحصيل  </label>
     <select id="treasuries_id" class="form-control">
        @if(!@empty($user_shift))
        <option selected value="{{ $user_shift['treasuries_id']  }}"> {{ $user_shift['name'] }} </option>
        @else
        <option value=""> عفوا لاتوجد خزنة لديك الان</option>
        @endif
     </select>
  </div>
</div>
<div class="col-md-3 > 
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