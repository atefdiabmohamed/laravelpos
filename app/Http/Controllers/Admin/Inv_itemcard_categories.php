<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inv_itemcard_categorie;
use App\Models\Admin;
use App\Http\Requests\Inv_itemcard_categoriesRequest;
class Inv_itemcard_categories extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
$data=inv_itemcard_categorie::select()->orderby('id','DESC')->paginate(PAGINATION_COUNT); 
if(!empty($data)){
foreach($data as $info){
$info->added_by_admin=Admin::where('id',$info->added_by)->value('name');    
if($info->updated_by>0 and $info->updated_by!=null){
$info->updated_by_admin=Admin::where('id',$info->updated_by)->value('name');    
}
}
}
return view('admin.inv_itemcard_categories.index',['data'=>$data]);    
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
return view('admin.inv_itemcard_categories.create');
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Inv_itemcard_categoriesRequest $request){
try{
$com_code=auth()->user()->com_code;
//check if not exsits
$checkExists=inv_itemcard_categorie::where(['name'=>$request->name,'com_code'=>$com_code])->first();
if($checkExists==null){
$data['name']=$request->name;
$data['active']=$request->active;
$data['created_at']=date("Y-m-d H:i:s");
$data['added_by']=auth()->user()->id;
$data['com_code']=$com_code;
$data['date']=date("Y-m-d");
inv_itemcard_categorie::create($data);
return redirect()->route('inv_itemcard_categories.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->back()
->with(['error'=>'عفوا اسم الفئة مسجل من قبل'])
->withInput(); 
}
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
} 
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}
public function edit($id){
$data=inv_itemcard_categorie::select()->find($id);
return view('admin.inv_itemcard_categories.edit',['data'=>$data]);
}         
public function update($id,Inv_itemcard_categoriesRequest $request){
try{
$com_code=auth()->user()->com_code;
$data=inv_itemcard_categorie::select()->find($id);
if(empty($data)){
return redirect()->route('inv_itemcard_categories.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists=inv_itemcard_categorie::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
if( $checkExists!=null){
return redirect()->back()
->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
->withInput(); 
}
$data_to_update['name']=$request->name;
$data_to_update['active']=$request->active;
$data_to_update['updated_by']=auth()->user()->id;
$data_to_update['updated_at']=date("Y-m-d H:i:s");
inv_itemcard_categorie::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
return redirect()->route('inv_itemcard_categories.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
}    
/*
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destory(){
}
public function delete($id){
try{
$Sales_matrial_types_row=inv_itemcard_categorie::find($id);
if(!empty($Sales_matrial_types_row)){
$flag=$Sales_matrial_types_row->delete();
if($flag){
return redirect()->back()
->with(['success'=>'   تم حذف البيانات بنجاح']);
}else{
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما']);
}
}else{
return redirect()->back()
->with(['error'=>'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
}
} 
}