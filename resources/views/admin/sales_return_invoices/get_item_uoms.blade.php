<div class="form-group">
  <label>     وحدة البيع</label>
  <select  id="uom_id" class="form-control select2" style="width: 100%;">
     @if (@isset($item_card_Data) && !@empty($item_card_Data))
     @if($item_card_Data['does_has_retailunit']==1)
     <option selected data-isparentuom="1"   value="{{ $item_card_Data['uom_id'] }}"> {{ $item_card_Data['parent_uom_name']  }} (وحده اب) </option>
     <option  data-isparentuom="0"   value="{{ $item_card_Data['retail_uom_id'] }}"> {{ $item_card_Data['retial_uom_name']  }} (وحدة تجزئة) </option>
     @else
     <option   data-isparentuom="1"  value="{{ $item_card_Data['uom_id'] }}"> {{ $item_card_Data['parent_uom_name']  }} (وحده اب) </option>
     @endif
     @endif
  </select>
</div>