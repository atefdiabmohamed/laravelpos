<select size="4"  name="customer_code" id="customer_code" class="form-control " required>
  <option value="">من فضلك اختر العميل  </option>
  @if (@isset($customers) && !@empty($customers) && count($customers))
  @php $i=1; @endphp
  @foreach ($customers as $info )
  <option data-startdate="{{ $info->date }}" @if($i==1) selected @endif  value="{{ $info->customer_code }}"> {{ $info->name }} </option>
  @php $i++; @endphp
  @endforeach
  @endif
</select>