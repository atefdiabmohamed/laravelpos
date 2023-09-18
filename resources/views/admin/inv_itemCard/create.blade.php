@extends('layouts.admin')
@section('title')
اضافة صنف 
@endsection
@section('contentheader')
الاصناف
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.itemcard.index') }}">  الاصناف </a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center"> اضافة صنف جديد</h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <input type="hidden" id="ajax_url_ajax_check_barcode" value="{{ route('admin.itemcard.ajax_check_barcode') }}" >
      <input type="hidden" id="ajax_url_ajax_check_name" value="{{ route('admin.itemcard.ajax_check_name') }}" >
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <form action="{{ route('admin.itemcard.store') }}" method="post" enctype="multipart/form-data" >
         <div class="row">
            @csrf
            <div class="col-md-6">
               <div class="form-group">
                  <label>  باركود الصنف - في حالة عدم الادخال سيولد بشكل الي</label> <span id="barcodeCheckMessage"> </span>
                  <input name="barcode" id="barcode" autofocus class="form-control" value="{{ old('barcode') }}" placeholder="ادخل  باركود الصنف"  >
                  @error('barcode')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>اسم  الصنف</label>  <span id="nameCheckMessage"> </span>
                  <input name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="ادخل اسم الصنف"   >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  نوع الصنف</label>
                  <select name="item_type" id="item_type" class="form-control">
                     <option value="">اختر النوع</option>
                     <option   @if(old('item_type')==1) selected="selected"  @endif value="1"> مخزني</option>
                     <option   @if(old('item_type')==2) selected="selected"  @endif value="2"> استهلاكي بتاريخ صلاحية</option>
                     <option   @if(old('item_type')==3) selected="selected"  @endif value="3"> عهدة</option>
                  </select>
                  @error('item_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  فئة الصنف</label>
                  <select name="inv_itemcard_categories_id" id="inv_itemcard_categories_id" class="form-control ">
                     <option value="">اختر الفئة</option>
                     @if (@isset($inv_itemcard_categories) && !@empty($inv_itemcard_categories))
                     @foreach ($inv_itemcard_categories as $info )
                     <option @if(old('inv_itemcard_categories_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('inv_itemcard_categories_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   الصنف الاب له</label>
                  <select name="parent_inv_itemcard_id" id="parent_inv_itemcard_id" class="form-control ">
                     <option selected value="0"> هو اب</option>
                     @if (@isset($item_card_data) && !@empty($item_card_data))
                     @foreach ($item_card_data as $info )
                     <option @if(old('parent_inv_itemcard_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('inv_itemcard_categories_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   وحدة القياس الاب</label>
                  <select name="uom_id" id="uom_id" class="form-control ">
                     <option value="">اختر الوحدة الاب</option>
                     @if (@isset($inv_uoms_parent) && !@empty($inv_uoms_parent))
                     @foreach ($inv_uoms_parent as $info )
                     <option @if(old('uom_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('uom_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   هل للصنف وحدة تجزئة ابن</label>
                  <select name="does_has_retailunit" id="does_has_retailunit" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option   @if(old('does_has_retailunit')==1) selected="selected"  @endif value="1"> نعم </option>
                     <option @if(old('does_has_retailunit')==0 and old('does_has_retailunit')!="" ) selected="selected"   @endif value="0"> لا</option>
                  </select>
                  @error('does_has_retailunit')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6  " @if(old('does_has_retailunit')!=1 ) style="display: none;" @endif  id="retail_uom_idDiv"> 
            <div class="form-group">
               <label>   وحدة القياس التجزئة الابن بالنسبة للأب(<span class="parentuomname"></span>)</label>
               <select name="retail_uom_id" id="retail_uom_id" class="form-control ">
                  <option value="">اختر الوحدة الاب</option>
                  @if (@isset($inv_uoms_child) && !@empty($inv_uoms_child))
                  @foreach ($inv_uoms_child as $info )
                  <option @if(old('retail_uom_id')==$info->id) selected="selected" @endif value="{{ $info->id }}"> {{ $info->name }} </option>
                  @endforeach
                  @endif
               </select>
               @error('retail_uom_id')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
         </div>
         <div class="col-md-6 relatied_retial_counter "  @if(old('retail_uom_id')=="" ) style="display: none;" @endif> 
         <div class="form-group">
            <label>عدد وحدات التجزئة  (<span class="childuomname"></span>) بالنسبة للأب (<span class="parentuomname"></span>)  </label>
            <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="retail_uom_quntToParent" id="retail_uom_quntToParent" class="form-control"  value="{{ old('retail_uom_quntToParent') }}" placeholder="ادخل  عدد وحدات التجزئة"  >
            @error('retail_uom_quntToParent')
            <span class="text-danger">{{ $message }}</span>
            @enderror
         </div>
   </div>
   <div class="col-md-6 relatied_parent_counter "  @if(old('uom_id')=='' ) style="display: none;" @endif> 
   <div class="form-group">
   <label>سعر القطاعي بوحدة (<span class="parentuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="price" id="price" class="form-control"  value="{{ old('price') }}" placeholder="ادخل السعر " >
   @error('price')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
</div>
<div class="col-md-6 relatied_parent_counter "  @if(old('uom_id')=='' ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر النص جملة بوحدة (<span class="parentuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="nos_gomla_price" id="nos_gomla_price" class="form-control"  value="{{ old('nos_gomla_price') }}" placeholder="ادخل السعر " >
@error('nos_gomla_price')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_parent_counter "  @if(old('uom_id')=='' ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  جملة بوحدة (<span class="parentuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="gomla_price" id="gomla_price" class="form-control"  value="{{ old('gomla_price') }}" placeholder="ادخل السعر " >
@error('gomla_price')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_parent_counter "  @if(old('uom_id')=='' ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  تكلفة الشراء لوحدة (<span class="parentuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="cost_price" id="cost_price" class="form-control"  value="{{ old('cost_price') }}" placeholder="ادخل السعر " >
@error('cost_price')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('retail_uom_id')=="" ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر القطاعي بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="price_retail" id="price_retail" class="form-control"  value="{{ old('price_retail') }}" placeholder="ادخل السعر " >
@error('price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('retail_uom_id')=="") style="display: none;" @endif> 
<div class="form-group">
<label>سعر النص جملة بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="nos_gomla_price_retail" id="nos_gomla_price_retail" class="form-control"  value="{{ old('nos_gomla_price_retail') }}" placeholder="ادخل السعر " >
@error('nos_gomla_price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('retail_uom_id')=="" ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  الجملة بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="gomla_price_retail" id="gomla_price_retail" class="form-control"  value="{{ old('gomla_price_retail') }}" placeholder="ادخل السعر " >
@error('gomla_price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('retail_uom_id')=="" ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  الشراء بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="cost_price_retail" id="cost_price_retail" class="form-control"  value="{{ old('cost_price_retail') }}" placeholder="ادخل السعر " >
@error('cost_price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group"> 
<label>  هل للصنف سعر ثابت  </label>
<select name="has_fixced_price" id="has_fixced_price" class="form-control">
<option value="">اختر الحالة</option>
<option   @if(old('has_fixced_price')==1) selected="selected"  @endif value="1"> نعم ثابت ولايتغير بالفواتير</option>
<option @if(old('has_fixced_price')==0 and old('active')!="" ) selected="selected"   @endif value="0"> لا وقابل للتغير بالفواتير</option>
</select>
@error('has_fixced_price')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6">
<div class="form-group"> 
<label>  حالة التفعيل</label>
<select name="active" id="active" class="form-control">
<option value="">اختر الحالة</option>
<option   @if(old('active')==1) selected="selected"  @endif value="1"> نعم</option>
<option @if(old('active')==0 and old('active')!="" ) selected="selected"   @endif value="0"> لا</option>
</select>
@error('active')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6" style="border:solid 5px #000 ; margin:10px;">
<div class="form-group"> 
<label>   صورة الصنف ان وجدت</label>
<img id="uploadedimg" src="#" alt="uploaded img" style="width: 200px; width: 200px;" >        
<input onchange="readURL(this)" type="file" id="Item_img" name="Item_img" class="form-control">
@error('active')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>  
<div class="col-md-12">
<div class="form-group text-center">
<button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> اضافة</button>
<a href="{{ route('admin.itemcard.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
</div>
</div>
</div>  
</form>  
</div>  
</div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
<script>
   var uom_id=$("#uom_id").val();
   if(uom_id!=""){
     var name=$("#uom_id option:selected").text();  
       $(".parentuomname").text(name); 
   }
   
   var uomretail_uom_id_id=$("#retail_uom_id").val();
   if(retail_uom_id!=""){
     var name=$("#retail_uom_id option:selected").text();  
       $(".childuomname").text(name); 
   }
</script>
@endsection