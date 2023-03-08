@extends('layouts.admin')
@section('title')
المناديب
@endsection
@section('contentheader')
الحسابات  
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.accounts.index') }}">    المناديب </a>
@endsection
@section('contentheaderactive')
تعديل
@endsection
@section('content')
<div class="card">
   <div class="card-header">
      <h3 class="card-title card_title_center"> تعديل بيانات مندوب  </h3>
   </div>
   <!-- /.card-header -->
   <div class="card-body">
      <form action="{{ route('admin.delegates.update',$data['id']) }}" method="post" >
         <div class="row">
            @csrf
            <div class="col-md-6">
               <div class="form-group">
                  <label>اسم  المندوب </label>
                  <input name="name" id="name" class="form-control" value="{{ old('name',$data['name']) }}"    >
                  @error('name')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   العنوان</label>
                  <input name="address" id="address" class="form-control" value="{{ old('address',$data['address']) }}"    >
                  @error('address')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   الهاتف</label>
                  <input name="phones" id="phones" class="form-control" value="{{ old('phones',$data['phones']) }}"    >
                  @error('phones')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   نوع عمولة  المندوب </label>
                  <select name="percent_type" id="percent_type" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option {{  old('percent_type',$data['percent_type'])==1 ? 'selected' : ''}}  value="1"> اجر ثابت</option>
                     <option {{  old('percent_type',$data['percent_type'])==2 ? 'selected' : ''}}   value="2"> نسبة</option>
                  </select>
                  @error('percent_type')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>    عمولة المندوب بالمبيعات قطاعي	</label>
                  <input  name="percent_salaes_commission_kataei" id="percent_salaes_commission_kataei"
                     class="form-control"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                     value="{{ old('percent_salaes_commission_kataei',$data['percent_salaes_commission_kataei']*1) }}"   >
                  @error('percent_salaes_commission_kataei')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  عمولة المندوب بمبيعات نص الجملة	</label>
                  <input  name="percent_salaes_commission_nosjomla" id="percent_salaes_commission_nosjomla" 
                     class="form-control"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                     value="{{ old('percent_salaes_commission_nosjomla',$data['percent_salaes_commission_nosjomla']*1) }}"    >
                  @error('percent_salaes_commission_nosjomla')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   عمولة المندوب بمبيعات الجملة	</label>
                  <input  name="percent_salaes_commission_jomla" id="percent_salaes_commission_jomla"
                     class="form-control"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                     value="{{ old('percent_salaes_commission_jomla',$data['percent_salaes_commission_jomla']*1) }}"   >
                  @error('percent_salaes_commission_jomla')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   عمولة المندوب  بتحصيل الآجل	</label>
                  <input  name="percent_collect_commission" id="percent_collect_commission" 
                     class="form-control"  oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                     value="{{ old('percent_collect_commission',$data['percent_collect_commission']*1) }}"   >
                  @error('percent_collect_commission')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>   ملاحظات</label>
                  <input name="notes" id="notes" class="form-control" value="{{ old('notes',$data['notes']) }}"    >
                  @error('notes')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label>  حالة التفعيل</label>
                  <select name="active" id="active" class="form-control">
                     <option value="">اختر الحالة</option>
                     <option {{  old('active',$data['active'])==1 ? 'selected' : ''}}  value="1"> نعم</option>
                     <option {{  old('active',$data['active'])==0 ? 'selected' : ''}}   value="0"> لا</option>
                  </select>
                  @error('active')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group text-center">
                  <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> تعديل</button>
                  <a href="{{ route('admin.delegates.index') }}" class="btn btn-sm btn-danger">الغاء</a>    
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection