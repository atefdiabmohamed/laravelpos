<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Treasuries;
use App\Models\Admin;
use App\Models\Treasuries_delivery;
use App\Http\Requests\TreasuriesRequest;
use App\Http\Requests\Addtreasuries_deliveryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class TreasuriesController extends Controller
{
public function index(){
$data=Treasuries::select()->orderby('id','DESC')->paginate(PAGINATION_COUNT); 
if(!empty($data)){
foreach($data as $info){
$info->added_by_admin=Admin::where('id',$info->added_by)->value('name');    
if($info->updated_by>0 and $info->updated_by!=null){
$info->updated_by_admin=Admin::where('id',$info->updated_by)->value('name');    
}
}
}
return view('admin.treasuries.index',['data'=>$data]);    
}
public function create(){
return view('admin.treasuries.create'); 
} 
public function store(TreasuriesRequest $request){
try{
$com_code=auth()->user()->com_code;
//check if not exsits
$checkExists=Treasuries::where(['name'=>$request->name,'com_code'=>$com_code])->first();
if($checkExists==null){
if($request->is_master==1){
$checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->first();
if($checkExists_isMaster!=null){
return redirect()->back()
->with(['error'=>'عفوا هناك خزنة رئيسية بالفعل مسجلة من قبل لايمكن ان يكون هناك اكثر من خزنة رئيسية'])
->withInput(); }
}
$data['name']=$request->name;
$data['is_master']=$request->is_master;
$data['last_isal_exhcange']=$request->last_isal_exhcange;
$data['last_isal_collect']=$request->last_isal_collect;
$data['active']=$request->active;
$data['created_at']=date("Y-m-d H:i:s");
$data['added_by']=auth()->user()->id;
$data['com_code']=$com_code;
$data['date']=date("Y-m-d");
Treasuries::create($data);
return redirect()->route('admin.treasuries.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->back()
->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
->withInput(); 
}
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
} 
public function edit($id){
$data=Treasuries::select()->find($id);
return view('admin.treasuries.edit',['data'=>$data]);
}
public function update($id,TreasuriesRequest $request){
try{
$com_code=auth()->user()->com_code;
$data=Treasuries::select()->find($id);
if(empty($data)){
return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists=Treasuries::where(['name'=>$request->name,'com_code'=>$com_code])->where('id','!=',$id)->first();
if( $checkExists!=null){
return redirect()->back()
->with(['error'=>'عفوا اسم الخزنة مسجل من قبل'])
->withInput(); 
}
if($request->is_master==1){
$checkExists_isMaster=Treasuries::where(['is_master'=>1,'com_code'=>$com_code])->where('id','!=',$id)->first();
if($checkExists_isMaster!=null){
return redirect()->back()
->with(['error'=>'عفوا هناك خزنة رئيسية بالفعل مسجلة من قبل لايمكن ان يكون هناك اكثر من خزنة رئيسية'])
->withInput(); 
}
}
$data_to_update['name']=$request->name;
$data_to_update['active']=$request->active;
$data_to_update['is_master']=$request->is_master;
$data_to_update['last_isal_exhcange']=$request->last_isal_exhcange;
$data_to_update['last_isal_collect']=$request->last_isal_collect;
$data_to_update['updated_by']=auth()->user()->id;
$data_to_update['updated_at']=date("Y-m-d H:i:s");
Treasuries::where(['id'=>$id,'com_code'=>$com_code])->update($data_to_update);
return redirect()->route('admin.treasuries.index')->with(['success'=>'لقد تم تحديث البيانات بنجاح']);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
}
public function ajax_search(Request $request){
if($request->ajax()){
$search_by_text=$request->search_by_text;
$data=Treasuries::where('name','LIKE',"%{$search_by_text}%")->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
return view('admin.treasuries.ajax_search',['data'=>$data]);
}
}

public function details($id){
try{
$com_code=auth()->user()->com_code;
$data=Treasuries::select()->find($id);
if(empty($data)){
return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
if($data['updated_by']>0 and $data['updated_by']!=null){
$data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
}
$treasuries_delivery=Treasuries_delivery::select()->where(['treasuries_id'=>$id])->orderby('id','DESC')->get(); 
if(!empty($treasuries_delivery)){
foreach($treasuries_delivery as $info){
$info->name=Treasuries::where('id',$info->treasuries_can_delivery_id)->value('name');    
$info->added_by_admin=Admin::where('id',$info->added_by)->value('name');    
}
}
return view("admin.treasuries.details",['data'=>$data,'treasuries_delivery'=>$treasuries_delivery]);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
}
}
public function Add_treasuries_delivery($id){
try{
$com_code=auth()->user()->com_code;
$data=Treasuries::select('id','name')->find($id);
if(empty($data)){
return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$Treasuries=Treasuries::select('id','name')->where(['com_code'=>$com_code,'active'=>1])->get();  
return view("admin.treasuries.Add_treasuries_delivery",['data'=>$data,'Treasuries'=>$Treasuries]);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
}
}
public function store_treasuries_delivery($id,Addtreasuries_deliveryRequest $request){
try{
$com_code=auth()->user()->com_code;
$Treasuries=new Treasuries();
$data=Treasuries::select('id','name')->find($id);
if(empty($data)){
return redirect()->route('admin.treasuries.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists=Treasuries_delivery::where(['treasuries_id'=>$id,'treasuries_can_delivery_id'=>$request->treasuries_can_delivery_id,'com_code'=>$com_code])->first();
if($checkExists!=null){
return redirect()->back()
->with(['error'=>'عفوا هذه الخزنة مسجلة من قبل !'])
->withInput(); 
}
$data_insert_details['treasuries_id']=$id;
$data_insert_details['treasuries_can_delivery_id']=$request->treasuries_can_delivery_id;
$data_insert_details['created_at']=date("Y-m-d H:i:s");
$data_insert_details['added_by']=auth()->user()->id;
$data_insert_details['com_code']=$com_code;
Treasuries_delivery::create($data_insert_details);
return redirect()->route('admin.treasuries.details',$id)->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
}
} 
public function delete_treasuries_delivery($id){
try{
$treasuries_delivery=Treasuries_delivery::find($id);
if(!empty($treasuries_delivery)){
$flag=$treasuries_delivery->delete();
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