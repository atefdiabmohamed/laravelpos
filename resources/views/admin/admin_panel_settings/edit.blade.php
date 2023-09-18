@extends('layouts.admin')
@section('title')
تعديل الضبط العام
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
الضبط
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.adminPanelSetting.index') }}"> الضبط </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">تعديل بيانات الضبط العام</h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      @if (@isset($data) && !@empty($data))
      <form action="{{ route('admin.adminPanelSetting.update') }}" method="post" enctype="multipart/form-data">
         @csrf
         <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                  <label>اسم الشركة</label>
                  <input name="system_name" id="system_name" class="form-control" value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                  @error('system_name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>عنوان الشركة</label>
                  <input name="address" id="address" class="form-control" value="{{ $data['address'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}"  >
                  @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror  
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>هاتف الشركة</label>
                  <input name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
                  @error('phone')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror   
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    الحساب الاب للعملاء بالشجرة المحاسبية</label>
                  <select name="customer_parent_account_number" id="customer_parent_account_number" class="form-control select2">
                     <option value="">اختر الحساب </option>
                     @if (@isset($parent_accounts) && !@empty($parent_accounts))
                     @foreach ($parent_accounts as $info )
                     <option @if(old('customer_parent_account_number',$data['customer_parent_account_number'])==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('customer_parent_account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    الحساب الاب للموردين بالشجرة المحاسبية</label>
                  <select name="suppliers_parent_account_number" id="suppliers_parent_account_number" class="form-control select2 ">
                     <option value="">اختر الحساب </option>
                     @if (@isset($parent_accounts) && !@empty($parent_accounts))
                     @foreach ($parent_accounts as $info )
                     <option @if(old('suppliers_parent_account_number',$data['suppliers_parent_account_number'])==$info->account_number) selected="selected" @endif value="{{ $info->account_number }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('suppliers_parent_account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    الحساب الاب للمناديب بالشجرة المحاسبية</label>
                  <select name="delegate_parent_account_number" id="delegate_parent_account_number" class="form-control select2 ">
                     <option value="">اختر الحساب </option>
                     @if (@isset($parent_accounts) && !@empty($parent_accounts))
                     @foreach ($parent_accounts as $info )
                     <option  @if(old('delegate_parent_account_number',$data['delegate_parent_account_number'])==$info->account_number) selected="selected" @endif  value="{{ $info->account_number }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('delegate_parent_account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    الحساب الاب للموظفين بالشجرة المحاسبية</label>
                  <select name="employees_parent_account_number" id="employees_parent_account_number" class="form-control select2">
                     <option value="">اختر الحساب </option>
                     @if (@isset($parent_accounts) && !@empty($parent_accounts))
                     @foreach ($parent_accounts as $info )
                     <option  @if(old('employees_parent_account_number',$data['employees_parent_account_number'])==$info->account_number) selected="selected" @endif  value="{{ $info->account_number }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('employees_parent_account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-4">
               <div class="form-group">
                  <label>    الحساب الاب لخطوط الانتاج بالشجرة المحاسبية</label>
                  <select name="production_lines_parent_account" id="production_lines_parent_account" class="form-control select2">
                     <option value="">اختر الحساب </option>
                     @if (@isset($parent_accounts) && !@empty($parent_accounts))
                     @foreach ($parent_accounts as $info )
                     <option  @if(old('production_lines_parent_account',$data['production_lines_parent_account'])==$info->account_number) selected="selected" @endif  value="{{ $info->account_number }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('production_lines_parent_account')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>

            @if ($data['is_set_Batches_setting']==0)
          
            <div class="col-md-4">
               <div class="form-group">
                  <label>    نوع آلية عمل الباتشات بالنظام</label>
                  <select name="Batches_setting_type" id="Batches_setting_type" class="form-control  ">
                     <option value="">اختر النوع </option>
                     <option value="1">  يعمل بنظام تعدد الباتشات للصنف طبقا لاختلاف سعر الشراء وتواريخ الانتاج والانتهاء </option>
                     <option value="2">    لايعمل بنظام الباتشات - فقط كمية لكل صنف</option>
             
                  </select>
                  @error('Batches_setting_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>


            @endif
            <div class="col-md-4">
               <div class="form-group">
                  <label>        وحدة البيع الاساسية بالفواتير</label>
                  <select name="default_unit" id="default_unit" class="form-control  ">
                     <option   @if(old('default_unit',$data['default_unit'])==1) selected="selected" @endif value="1">  بيع تلقائي بالوحدة الاساسية الاب</option>
                     <option  @if(old('default_unit',$data['default_unit'])==2) selected="selected" @endif value="2">  بيع تلقائي بالوحدة الفرعية التجزئة</option>
                  </select>
                  @error('default_unit')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label>رسالة تنبية اعلي الشاشة </label>
                  <input name="general_alert" id="general_alert" class="form-control" value="{{ $data['general_alert'] }}" placeholder="ادخل اسم الشركة" oninvalid="setCustomValidity('من فضلك ادخل هذا الحقل')" onchange="try{setCustomValidity('')}catch(e){}" >
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group"  >
                  <label>شعار الشركة</label>
                  <div class="image">
                     <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}"  alt="لوجو الشركة">       
                     <button type="button" class="btn btn-sm btn-danger" id="update_image">تغير الصورة</button>
                     <button type="button" class="btn btn-sm btn-danger" style="display: none;" id="cancel_update_image"> الغاء</button>
                  </div>
               </div>
               <div id="oldimage">
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm">حفظ التعديلات</button>
               </div>
            </div>
         </div>
      </form>
      @else
      <div class="alert alert-danger">
         عفوا لاتوجد بيانات لعرضها !!
      </div>
      @endif
   </div>
</div>
@endsection
@section("script")
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script  src="{{ asset('assets/admin/js/collect_transaction.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection