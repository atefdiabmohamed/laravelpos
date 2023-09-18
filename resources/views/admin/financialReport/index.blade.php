@extends('layouts.admin')
@section('title')
التقارير
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
تقارير حسابات  
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.accounts.index') }}">    تقرير مورد </a>
@endsection
@section('contentheaderactive')
عرض
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center">   تقارير الموردين  </h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <form target="_blank" action="{{ route('admin.FinancialReport.supplieraccountmirror') }}" method="POST">
         @csrf
         <div class="row">
            <div class="col-md-3">
               <div class="form-group">
                  <input type="hidden" id="todaydate" value="@php echo date('Y-m-d'); @endphp">
                  <label>   بيانات الموردين</label>
                  <select name="suuplier_code" id="suuplier_code" class="form-control select2"  required>
                     <option value="">اختر المورد</option>
                     @if (@isset($suppliers) && !@empty($suppliers))
                     @foreach ($suppliers as $info )
                     <option data-startdate="{{ $info->date }}" value="{{ $info->suuplier_code }}"> {{ $info->name }} </option>
                     @endforeach
                     @endif
                  </select>
                  @error('suuplier_code')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-3">
               <div class="form-group">
                  <label>    نوع التقرير</label>
                  <select name="report_type" id="report_type" class="form-control">
                     <option   value="1"> كشف حساب اجمالي</option>
                     <option  selected value="2"> كشف حساب تفصيلي خلال فترة</option>
                     <option  value="3"> كشف حساب المشتريات خلال فترة</option>
                     <option  value="4"> كشف حساب مرتجع المشتريات خلال فترة</option>
                     <option  value="6"> كشف حساب حركة الخدمات خلال فترة</option>
                     <option  value="5"> كشف حساب حركة النقدية خلال فترة</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3" id="Does_show_itemsDiv">
               <div class="form-group">
                  <label>     اظهار الاصناف</label>
                  <select name="Does_show_items" id="Does_show_items" class="form-control">
                     <option   value="1"> نعم</option>
                     <option  selected value="2"> لا</option>
                  </select>
               </div>
            </div>
            <div class="col-md-3 relatedDate"  >
               <div class="form-group">
                  <label>      من تاريخ </label>
                  <input name="from_date" id="from_date" class="form-control" type="date" value=""    >
               </div>
            </div>
            <div class="col-md-3 relatedDate" >
               <div class="form-group">
                  <label>     الي تاريخ  </label>
                  <input name="to_date" id="to_date" class="form-control" type="date" value=""    >
               </div>
            </div>
            <div class="col-md-2 text-center"> 
               <button style="margin-top: 31px;" type="submit" class="btn btn-sm btn-danger">عرض التقرير</button>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
@endsection
@section("script")
<script  src="{{ asset('assets/admin/js/financialReport.js') }}"> </script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection