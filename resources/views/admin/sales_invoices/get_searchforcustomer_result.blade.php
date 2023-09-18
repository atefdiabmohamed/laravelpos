<select size="4"  name="customer_code" id="customer_code" class="form-control select2">
  <option @if(@isset($customers) && count($customers)==0) selected @endif value=""> لايوجد عميل</option>
  @if (@isset($customers) && !@empty($customers) && count($customers))
  @php $i=1; @endphp
  @foreach ($customers as $info )
  <option @if($i==1) selected @endif  value="{{ $info->customer_code }}"> {{ $info->name }} ( كود {{ $info->customer_code }}) - (عدد فواتير {{$info->SalesInvoicesCounter}} ) </option>
  @php $i++; @endphp
  @endforeach
  @endif
  </select>