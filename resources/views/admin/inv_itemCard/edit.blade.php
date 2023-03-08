@extends('layouts.admin')
@section('title')
تعديل صنف 
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
      <h3 class="card-title card_title_center"> تعديل بيانات صنف </h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <input type="hidden" id="ajax_url_ajax_check_barcode" value="{{ route('admin.itemcard.ajax_check_barcode') }}" >
      <input type="hidden" id="ajax_url_ajax_check_name" value="{{ route('admin.itemcard.ajax_check_name') }}" >
      <input type="hidden" id="token_search" value="{{csrf_token() }}">
      <form action="{{ route('admin.itemcard.update',$data['id']) }}" method="post" enctype="multipart/form-data" >
         <div class="row">
            @csrf
            <div class="col-md-6">
               <div class="form-group">
                  <label>  باركود الصنف   <span id="barcodeCheckMessage"> </span></label>
                  <input name="barcode" id="barcode" class="form-control" value="{{ old('name',$data['barcode']) }}" placeholder="ادخل  باركود الصنف"  >
                  @error('barcode')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>اسم  الصنف  <span id="nameCheckMessage"> </span></label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}" placeholder="ادخل اسم الصنف"   >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  نوع الصنف</label>
                  <select  @if($counterUsedBefore>0) disabled  @endif name="item_type" id="item_type" class="form-control">
                  <option value="">اختر النوع</option>
                  <option {{  old('item_type',$data['item_type'])==1 ? 'selected' : ''}}   value="1"> مخزني</option>
                  <option {{  old('item_type',$data['item_type'])==2 ? 'selected' : ''}}   value="2"> استهلاكي بتاريخ صلاحية</option>
                  <option {{  old('item_type',$data['item_type'])==3 ? 'selected' : ''}}   value="3"> عهدة</option>
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
                     <option {{  old('inv_itemcard_categories_id',$data['inv_itemcard_categories_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
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
                     <option {{  old('parent_inv_itemcard_id',$data['parent_inv_itemcard_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
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
                  <select @if($counterUsedBefore>0) disabled  @endif  name="uom_id" id="uom_id" class="form-control ">
                  <option value="">اختر الوحدة الاب</option>
                  @if (@isset($inv_uoms_parent) && !@empty($inv_uoms_parent))
                  @foreach ($inv_uoms_parent as $info )
                  <option {{  old('uom_id',$data['uom_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
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
                  <select @if($counterUsedBefore>0) disabled  @endif  name="does_has_retailunit" id="does_has_retailunit" class="form-control">
                  <option value="">اختر الحالة</option>
                  <option {{  old('does_has_retailunit',$data['does_has_retailunit'])==1 ? 'selected' : ''}} value="1"> نعم </option>
                  <option {{  old('does_has_retailunit',$data['does_has_retailunit'])==0 ? 'selected' : ''}} value="0"> لا</option>
                  </select>
                  @error('does_has_retailunit')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6  " @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 ) style="display: none;" @endif  id="retail_uom_idDiv"> 
            <div class="form-group">
               <label>   وحدة القياس التجزئة الابن بالنسبة للأب(<span class="parentuomname"></span>)</label>
               <select @if($counterUsedBefore>0) disabled  @endif  name="retail_uom_id" id="retail_uom_id" class="form-control ">
               <option value="">اختر الوحدة الاب</option>
               @if (@isset($inv_uoms_child) && !@empty($inv_uoms_child))
               @foreach ($inv_uoms_child as $info )
               <option {{  old('retail_uom_id',$data['retail_uom_id'])==$info->id ? 'selected' : ''}} value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
               </select>
               @error('retail_uom_id')
               <span class="text-danger">{{ $message }}</span>
               @enderror
            </div>
         </div>
         <div class="col-md-6 relatied_retial_counter "  @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 )  style="display: none;" @endif> 
         <div class="form-group">
            <label>عدد وحدات التجزئة  (<span class="childuomname"></span>) بالنسبة للأب (<span class="parentuomname"></span>)  </label>
            <input @if($counterUsedBefore>0) disabled  @endif  oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="retail_uom_quntToParent" id="retail_uom_quntToParent" class="form-control"  value="{{ old('retail_uom_quntToParent',$data['retail_uom_quntToParent']*1) }}" placeholder="ادخل  عدد وحدات التجزئة"  >
            @error('retail_uom_quntToParent')
            <span class="text-danger">{{ $message }}</span>
            @enderror
         </div>
   </div>
   <div class="col-md-6 relatied_parent_counter "> 
   <div class="form-group">
   <label>سعر القطاعي بوحدة (<span class="parentuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="price" id="price" class="form-control"  value="{{ old('price',$data['price']*1) }}" placeholder="ادخل السعر " >
   @error('price')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
   </div>
   <div class="col-md-6 relatied_parent_counter "  > 
   <div class="form-group">
   <label>سعر النص جملة بوحدة (<span class="parentuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="nos_gomla_price" id="nos_gomla_price" class="form-control"  value="{{ old('nos_gomla_price',$data['nos_gomla_price']*1) }}" placeholder="ادخل السعر " >
   @error('nos_gomla_price')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
   </div>
   <div class="col-md-6 relatied_parent_counter " > 
   <div class="form-group">
   <label>سعر  جملة بوحدة (<span class="parentuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="gomla_price" id="gomla_price" class="form-control"  value="{{ old('gomla_price',$data['gomla_price']*1) }}" placeholder="ادخل السعر " >
   @error('gomla_price')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
   </div>
   <div class="col-md-6 relatied_parent_counter "  > 
   <div class="form-group">
   <label>سعر  تكلفة الشراء لوحدة (<span class="parentuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="cost_price" id="cost_price" class="form-control"  value="{{ old('cost_price',$data['cost_price']*1) }}" placeholder="ادخل السعر " >
   @error('cost_price')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
   </div>
   <div class="col-md-6 relatied_retial_counter " @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 ) style="display: none;" @endif> 
   <div class="form-group">
   <label>سعر القطاعي بوحدة (<span class="childuomname"></span>)  </label>
   <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="price_retail" id="price_retail" class="form-control"  value="{{ old('price_retail',$data['price_retail']*1) }}" placeholder="ادخل السعر " >
   @error('price_retail')
   <span class="text-danger">{{ $message }}</span>
   @enderror
   </div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر النص جملة بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="nos_gomla_price_retail" id="nos_gomla_price_retail" class="form-control"  value="{{ old('nos_gomla_price_retail',$data['nos_gomla_price_retail']*1) }}" placeholder="ادخل السعر " >
@error('nos_gomla_price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  الجملة بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="gomla_price_retail" id="gomla_price_retail" class="form-control"  value="{{ old('gomla_price_retail',$data['gomla_price_retail']*1) }}" placeholder="ادخل السعر " >
@error('gomla_price_retail')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6 relatied_retial_counter " @if(old('does_has_retailunit',$data['does_has_retailunit'])!=1 ) style="display: none;" @endif> 
<div class="form-group">
<label>سعر  الشراء بوحدة (<span class="childuomname"></span>)  </label>
<input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="cost_price_retail" id="cost_price_retail" class="form-control"  value="{{ old('cost_price_retail',$data['cost_price_retail']*1) }}" placeholder="ادخل السعر " >
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
<option   {{  old('has_fixced_price',$data['has_fixced_price'])==1 ? 'selected' : ''}} value="1"> نعم ثابت ولايتغير بالفواتير</option>
<option {{  old('has_fixced_price',$data['has_fixced_price'])==0 ? 'selected' : ''}} value="0"> لا وقابل للتغير بالفواتير</option>
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
<option  {{  old('active',$data['active'])==1 ? 'selected' : ''}} value="1"> نعم</option>
<option {{  old('active',$data['active'])==0 ? 'selected' : ''}} value="0"> لا</option>
</select>
@error('active')
<span class="text-danger">{{ $message }}</span>
@enderror
</div>
</div>
<div class="col-md-6" style="border:solid 5px #000 ; margin:10px;">
<div class="form-group"  >
<label> صورة الصنف</label>
<div class="image">
<img id="uploadedimg" class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}"  alt="لوجو الصنف">       
<button type="button" class="btn btn-sm btn-danger" id="update_image">تغير الصورة</button>
<button type="button" class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image"> الغاء</button>
</div>
<div id="oldimage">
</div>
</div> 
</div>  
<div class="col-md-12">
<div class="form-group text-center">
<button id="do_edit_item_cardd" type="submit" class="btn btn-primary btn-sm"> حفظ التعديلات</button>
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