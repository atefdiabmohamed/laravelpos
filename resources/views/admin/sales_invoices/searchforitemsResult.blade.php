<select 
@if(@isset($item_cards) && @empty($item_cards) && count($item_cards)==0 )
size="1" 
@else
size="4" 
@endif
id="item_code" name="item_code" class="form-control " style="width: 100%;">
<option   @if(@isset($item_cards) && @empty($item_cards) && count($item_cards)==0 ) selected  @endif value="" >اختر الصنف</option>
@if(@isset($item_cards) && !@empty($item_cards) && count($item_cards)>0)
@php $i=1; @endphp
@foreach ($item_cards as $info )
<option @if($i==1) selected @endif data-item_type="{{ $info->item_type }}"  
value="{{ $info->item_code }}"> {{ $info->name }} 
@php $i++; @endphp
@endforeach
@endif
</select>