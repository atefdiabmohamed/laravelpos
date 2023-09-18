@extends('layouts.admin')
@section('title')
شفتات الخزن
@endsection
@section('contentheader')
حركة الخزنية
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.admin_shift.index') }}">  شفتات الخزن </a>
@endsection
@section('contentheaderactive')
استلام شفت جديد
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center">   استلام خزنة لشفت جديد </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.admin_shift.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>     بيانات الخزن المضافة لصلاحياتي</label>
                  <select name="treasuries_id" id="treasuries_id" class="form-control ">
                     <option selected value="">  من فضلك اختر الخزنة لاستلامها وبدء الشفت </option>
                     @if (@isset($admins_treasuries) && !@empty($admins_treasuries))
                     @foreach ($admins_treasuries as $info )
                     <option  value="{{ $info->treasuries_id }}" @if($info->avaliable==false) disabled  @endif    > {{ $info->treasuries_name }} @if($info->avaliable==false) (غير متاحه لإستخدامها حاليا مع مستخدم اخر)  @endif </option>
                     @endforeach
                     @endif
                  </select>
                  @error('treasuries_id')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                  <a href="{{ route('admin.admin_shift.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection