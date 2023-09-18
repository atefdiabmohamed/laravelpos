@extends('layouts.admin')
@section('title')
ضبط الاصناف
@endsection
@section("css")
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('contentheader')
الاصناف
@endsection
@section('contentheaderlink')
<a href="{{ route('admin.itemcard.index') }}">  الاصناف </a>
@endsection
@section('contentheaderactive')
عرض التفاصيل
@endsection
@section('content')
<div class="card">
<div class="card-header">
   <h3 class="card-title card_title_center">  عرض بيانات صنف</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
   @if (@isset($data) && !@empty($data))
   <div class="row">
      <table id="example2" class="table table-bordered table-hover">
         <tr>
            <td colspan="3">
               <label>كود الصنف الثابت الالي من النظام</label> <br>
               {{ $data['item_code'] }}
               <input type="hidden" id="token_search" value="{{csrf_token() }}">
               <input type="hidden" id="ajax_search_movements" value="{{ route('admin.itemcard.ajax_search_movements') }}">
            </td>
         </tr>
         <tr>
            <td>
               <label>باركود الصنف</label> <br>
               {{ $data['barcode'] }}
            </td>
            <td>
               <label>اسم الصنف</label> <br>
               {{ $data['name'] }}
            </td>
            <td>
               <label>نوع الصنف</label> <br>
               @if($data['item_type']==1) مخزني  @elseif($data['item_type']==2) استهلاكي بصلاحية   @elseif($data['item_type']==3) عهدة @else غير محدد @endif
            </td>
         </tr>
         <tr>
            <td>
               <label>فئة الصنف</label> <br>
               {{ $data['inv_itemcard_categories_name'] }}
            </td>
            <td>
               <label> الصنف الاب</label> <br>
               {{ $data['parent_item_name'] }}
            </td>
            <td>
               <label>وحدة القياس الاب </label> <br>
               {{ $data['Uom_name'] }}
            </td>
         </tr>
         <tr>
            <td @if($data['does_has_retailunit']==0) colspan="3"   @endif >
            <label>   هل للصنف وحدة تجزئة ابن</label> <br>
            @if($data['does_has_retailunit']==1) نعم  @else  لا @endif
            </td> 
            @if($data['does_has_retailunit']==1)
            <td>
               <label>  وحدة القياس التجزئة</label> <br>
               {{ $data['retail_uom_name'] }}
            </td>
            <td>
               <label>  عدد وحدات  التجزئة {{ $data['retail_uom_name']  }} بالنسبة {{ $data['Uom_name']  }} </label> <br>
               {{ $data['retail_uom_quntToParent']*1 }}
            </td>
            @endif
         </tr>
         <tr>
            <td @if($data['does_has_retailunit']==0) colspan="3"   @endif >
            <label>   هل للصنف وحدة تجزئة ابن</label> <br>
            @if($data['does_has_retailunit']==1) نعم  @else  لا @endif
            </td> 
            @if($data['does_has_retailunit']==1)
            <td>
               <label>  وحدة القياس التجزئة</label> <br>
               {{ $data['retail_uom_name'] }}
            </td>
            <td>
               <label>  عدد وحدات  التجزئة {{ $data['retail_uom_name']  }} بالنسبة {{ $data['Uom_name']  }} </label> <br>
               {{ $data['retail_uom_quntToParent']*1 }}
            </td>
            @endif
         </tr>
         <tr>
            <td>
               <label> سعر القطاعي جملة بوحدة (  {{ $data['Uom_name']  }})</label> <br>
               {{ $data['price']*1 }}
            </td>
            <td>
               <label> سعر النص جملة بوحدة (  {{ $data['Uom_name']  }})</label> <br>
               {{ $data['nos_gomla_price']*1 }}
            </td>
            <td>
               <label> سعر  جملة بوحدة (  {{ $data['Uom_name']  }})</label> <br>
               {{ $data['gomla_price']*1 }}
            </td>
         </tr>
         <tr>
            <td @if($data['does_has_retailunit']==0) colspan="3"   @endif >
            <label> سعر تكلفة الشراء  بوحدة (  {{ $data['Uom_name']  }})</label> <br>
            {{ $data['cost_price']*1 }}
            </td>
            @if($data['does_has_retailunit']==1) 
            <td>
               <label> سعر القطاعي  بوحدة (  {{ $data['retail_uom_name']  }})</label> <br>
               {{ $data['price_retail']*1 }}
            </td>
            <td>
               <label> سعر  النص جملة بوحدة (  {{ $data['retail_uom_name']  }})</label> <br>
               {{ $data['nos_gomla_price_retail'] *1}}
            </td>
            @endif
         </tr>
         @if($data['does_has_retailunit']==1)
         <tr>
            <td colspan="1">
               <label> سعر تكلفة الشراء  بوحدة (  {{ $data['retail_uom_name']  }})</label> <br>
               {{ $data['cost_price_retail']*1 }} 
            </td>
         </tr>
         @endif
         <tr>
            <td colspan="2">
               كمية الصنف الحالية (  {{ $data['All_QUENTITY']*1  }} {{ $data['Uom_name']  }})
            </td>
         </tr>
         <tr>
            <td>
               <label> هل للصنف سعر ثابت</label> <br>
               @if($data['has_fixced_price']==1) نعم  @else  لا @endif
            </td>
            <td colspan="2">
               <label>  حالة التفعيل</label> <br>
               @if($data['active']==1) نعم  @else  لا @endif
            </td>
         </tr>
         <tr>
            <td >لوجو  الصنف</td>
            <td colspan="2" >
               <div class="image">
                  <img class="custom_img" src="{{ asset('assets/admin/uploads').'/'.$data['photo'] }}"  alt="لوجو الشركة">       
               </div>
            </td>
         </tr>
         <tr>
            <td >  تاريخ اخر تحديث</td>
            <td colspan="2"> 
               @if($data['updated_by']>0 and $data['updated_by']!=null )
               @php
               $dt=new DateTime($data['updated_at']);
               $date=$dt->format("Y-m-d");
               $time=$dt->format("h:i");
               $newDateTime=date("A",strtotime($time));
               $newDateTimeType= (($newDateTime=='AM')?'صباحا ':'مساء'); 
               @endphp
               {{ $date }}
               {{ $time }}
               {{ $newDateTimeType }}
               بواسطة 
               {{ $data['updated_by_admin'] }}
               @else
               لايوجد تحديث
               @endif
               <a href="{{ route('admin.itemcard.edit',$data['id']) }}" class="btn btn-sm btn-success">تعديل</a>
            </td>
         </tr>
      </table>
   </div>
   <hr style="border:1px solid #3c8dbc;">
   <h3 class="customh3"> سجل الحركة علي الصنف  (  كارت الصنف )</h3>
   <div class="row">
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث بالمخازن </label>
            <select name="store_id_move_search" id="store_id_move_search" class="form-control select2">
               <option value="all">بحث بالكل </option>
               @if (@isset($stores) && !@empty($stores))
               @foreach ($stores as $info )
               <option value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث بقسم الحركة </label>
            <select name="movements_categoriesMoveSearch" id="movements_categoriesMoveSearch" class="form-control select2">
               <option value="all">بحث بالكل </option>
               @if (@isset($inv_itemcard_movements_categories) && !@empty($inv_itemcard_movements_categories))
               @foreach ($inv_itemcard_movements_categories as $info )
               <option value="{{ $info->id }}"> {{ $info->name }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث بنوع الحركة </label>
            <select name="movements_typesMoveSearch" id="movements_typesMoveSearch" class="form-control select2">
               <option value="all">بحث بالكل </option>
               @if (@isset($inv_itemcard_movements_types) && !@empty($inv_itemcard_movements_types))
               @foreach ($inv_itemcard_movements_types as $info )
               <option value="{{ $info->id }}"> {{ $info->type }} </option>
               @endforeach
               @endif
            </select>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>      بحث من تاريخ حركة</label>
            <input name="from_date_moveSearch" id="from_date_moveSearch" class="form-control" type="date" value=""    >
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>     بحث الي تاريخ حركة </label>
            <input name="to_date_moveSearch" id="to_date_moveSearch" class="form-control" type="date" value=""    >
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group">
            <label>  بحث  بالترتيب </label>
            <select name="moveDateorderType" id="moveDateorderType" class="form-control select2">
               <option value="DESC">بحث ترتيب تنازلي </option>
               <option value="ASC">بحث ترتيب تصاعدي </option>
            </select>
         </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 text-center" id="ajaxSearchMovementsDiv">
         <button class="btn btn-sm btn-danger" id="ShowMovementsBtn">عرض سجل الحركة </button>
      </div>
      @else
      <div class="alert alert-danger">
         عفوا لاتوجد بيانات لعرضها !!
      </div>
      @endif
   </div>
</div>
@endsection
@section("script")
<script src="{{ asset('assets/admin/js/inv_itemcard.js') }}"></script>
<script  src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"> </script>
<script>
   //Initialize Select2 Elements
   $('.select2').select2({
     theme: 'bootstrap4'
   });
</script>
@endsection