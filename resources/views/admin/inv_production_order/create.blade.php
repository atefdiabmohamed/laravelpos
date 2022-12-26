@extends('layouts.admin')
@section('title')
حركات خط الاإنتاج
@endsection
@section('contentheader')
اوامر التشغيل
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.inv_production_order.index') }}">  اوامر التشغيل</a>
@endsection
@section('contentheaderactive')
اضافة
@endsection
@section('content')
<div class="row">
   <div class="col-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title card_title_center"> اضافة أمر تشغيل جديد </h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form action="{{ route('admin.inv_production_order.store') }}" method="post" >
               @csrf
               <div class="form-group">
                  <label>  تاريخ خطة أمر التشغيل </label> 
                  <input type="date" name="production_plan_date" value="{{ old('production_plan_date') }}" class="form-control" id="production_plan_date" >
                  @error('production_plan_date')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group">
                  <label>  تفاصيل خطة أمر التشغيل </label>
                  <textarea autofocus name="production_plane" rows="10" id="production_plane" class="form-control">{{ old('production_plane') }}</textarea>
                  @error('production_plane')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
               <div class="form-group text-center">
                  <button type="submit" class="btn btn-primary btn-sm"> اضافة</button>
                  <a href="{{ route('admin.inv_production_order.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
@endsection