<div class="form-group">
  <label>   بيانات وحدات الصنف</label>
  <select  id="uom_id_Add" class="form-control select2" style="width: 100%;">
     <option value="">اختر الوحده</option>
     @if (@isset($item_card_Data) && !@empty($item_card_Data))
     @if($item_card_Data['does_has_retailunit']==1)
     <option data-isparentuom="1" selected   value="{{ $item_card_Data['uom_id'] }}"> {{ $item_card_Data['parent_uom_name']  }} (وحده اب) </option>
     <option  data-isparentuom="0"   value="{{ $item_card_Data['retail_uom_id'] }}"> {{ $item_card_Data['retial_uom_name']  }} (وحدة تجزئة) </option>
     @else
     <option   data-isparentuom="1" selected   value="{{ $item_card_Data['uom_id'] }}"> {{ $item_card_Data['parent_uom_name']  }} (وحده اب) </option>
     @endif
     @endif
  </select>
</div>