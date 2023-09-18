<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admins_treasuries;
use App\Models\Treasuries;
use App\Models\Permission_rols;
use App\Models\Admins_stores;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\AdminRequestUpdate;
use App\Models\Store;

class AdminController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Admin(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->permission_roles_name = Permission_rols::where('id', $info->permission_roles_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
$Permission_rols=get_cols_where(new Permission_rols(),array("id","name"),array("active"=>1,'com_code'=>$com_code,'active'=>1),'id','ASC');

return view('admin.admins_accounts.index', ['data' => $data,'Permission_rols'=>$Permission_rols]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$Permission_rols=get_cols_where(new Permission_rols(),array("id","name"),array("active"=>1,'com_code'=>$com_code,'active'=>1),'id','ASC');
return view('admin.admins_accounts.create',['Permission_rols'=>$Permission_rols]);
}
public function store(AdminRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits
$checkExists_name = Admin::where(['name' => $request->name, 'com_code' => $com_code])->first();
if (!empty($checkExists_name)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المستخدم كاملا  مسجل من قبل'])
->withInput();
}
$checkExists_email = Admin::where(['email' => $request->email, 'com_code' => $com_code])->first();
if (!empty($checkExists_email)) {
return redirect()->back()
->with(['error' => 'عفوا البريد الالكتروني للمتسخدم    مسجل من قبل'])
->withInput();
}
$checkExists_username = Admin::where(['username' => $request->username, 'com_code' => $com_code])->first();
if (!empty($checkExists_username)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المستخدم للدخول   مسجل من قبل'])
->withInput();
}
$data['name'] = $request->name;
$data['permission_roles_id'] = $request->permission_roles_id;
$data['username'] = $request->username;
$data['email'] = $request->email;
$data['password'] = bcrypt($request->password);
$data['active'] = $request->active;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
Admin::create($data);
return redirect()->route('admin.admins_accounts.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$id));
$Permission_rols=get_cols_where(new Permission_rols(),array("id","name"),array("active"=>1,'com_code'=>$com_code,'active'=>1),'id','ASC');
return view('admin.admins_accounts.edit', ['data' => $data,'Permission_rols'=>$Permission_rols]);
}
public function update($id, AdminRequestUpdate $request)
{
try { 
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$id));

if (empty($data)) {
return redirect()->route('admin.admins_accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
//check if not exsits
$checkExists_name = Admin::where(['name' => $request->name, 'com_code' => $com_code])->where('id','!=',$id)->first();
if (!empty($checkExists_name)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المستخدم كاملا  مسجل من قبل'])
->withInput();
}
$checkExists_email = Admin::where(['email' => $request->email, 'com_code' => $com_code])->where('id','!=',$id)->first();
if (!empty($checkExists_email)) {
return redirect()->back()
->with(['error' => 'عفوا البريد الالكتروني للمتسخدم    مسجل من قبل'])
->withInput();
}
$checkExists_username = Admin::where(['username' => $request->username, 'com_code' => $com_code])->where('id','!=',$id)->first();
if (!empty($checkExists_username)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المستخدم للدخول   مسجل من قبل'])
->withInput();
}

$data_to_update['name'] = $request->name;
$data_to_update['permission_roles_id'] = $request->permission_roles_id;
$data_to_update['username'] = $request->username;
$data_to_update['email'] = $request->email;
if($request->checkForupdatePassword==1)
{
    $data_to_update['password'] = bcrypt($request->password);
}

$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
Admin::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
return redirect()->route('admin.admins_accounts.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function details($id){
    try{
    $com_code=auth()->user()->com_code;
    $data=get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$id));
    if(empty($data)){
    return redirect()->route('admin.admins_accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    $data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
    $data['permission_roles_name']=Admin::where('id',$data['permission_roles_id'])->value('name');    
    if($data['updated_by']>0 and $data['updated_by']!=null){
    $data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
    }
   $treasuries=get_cols_where(new Treasuries(),array("id","name"),array("com_code"=>$com_code,"active"=>1));
   $stores=get_cols_where(new Store(),array("id","name"),array("com_code"=>$com_code,"active"=>1));

   $admins_treasuries=get_cols_where(new Admins_treasuries(),array("*"),array("com_code"=>$com_code,"admin_id"=>$id));
   if (!empty($admins_treasuries)) {
    foreach ($admins_treasuries as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }

    $admins_stores=get_cols_where(new Admins_stores(),array("*"),array("com_code"=>$com_code,"admin_id"=>$id));
    if (!empty($admins_stores)) {
     foreach ($admins_stores as $info) {
     $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
     $info->store_name = Store::where('id', $info->store_id)->value('name');
     if ($info->updated_by > 0 and $info->updated_by != null) {
     $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
     }
     }
     }


   return view("admin.admins_accounts.details",['data'=>$data,'treasuries'=>$treasuries,'admins_treasuries'=>$admins_treasuries,'admins_stores'=>$admins_stores,'stores'=>$stores]);
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
    }
    }




public function add_treasuries($id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data=get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$id));
if(empty($data)){
return redirect()->route('admin.admins_accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$treasuries_ids=$request->treasuries_ids;
if(empty($treasuries_ids)){
return redirect()->route('admin.admins_accounts.details',$id)->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
foreach($treasuries_ids as $info){
$dataToInsert['com_code']=$com_code;
$dataToInsert['admin_id']=$id;
$dataToInsert['treasuries_id']=$info;
$checkExists = get_cols_where_row(new Admins_treasuries(),array("id"),$dataToInsert);
if(empty($checkExists)){
$dataToInsert['added_by'] = auth()->user()->id;
$dataToInsert['active'] = 1;
$dataToInsert['created_at'] = date("Y-m-d H:i:s");
$dataToInsert['date'] = date("Y-m-d");
insert(new Admins_treasuries(),$dataToInsert);
}
}
return redirect()->route('admin.admins_accounts.details',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function delete_treasuries($rowid,$userid)
{
try {

    $com_code = auth()->user()->com_code;
    $data=get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$userid));
    if(empty($data)){
    return redirect()->route('admin.admins_accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }  
$item_row = Admins_treasuries::find($rowid);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function add_stores($id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data=get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$id));
if(empty($data)){
return redirect()->route('admin.admins_accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$stores_ids=$request->stores_ids;
if(empty($stores_ids)){
return redirect()->route('admin.admins_accounts.details',$id)->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
foreach($stores_ids as $info){
$dataToInsert['com_code']=$com_code;
$dataToInsert['admin_id']=$id;
$dataToInsert['store_id']=$info;
$checkExists = get_cols_where_row(new Admins_stores(),array("id"),$dataToInsert);
if(empty($checkExists)){
$dataToInsert['added_by'] = auth()->user()->id;
$dataToInsert['active'] = 1;
$dataToInsert['created_at'] = date("Y-m-d H:i:s");
$dataToInsert['date'] = date("Y-m-d");
insert(new Admins_stores(),$dataToInsert);
}
}
return redirect()->route('admin.admins_accounts.details',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function delete_stores($rowid,$userid)
{
try {

    $com_code = auth()->user()->com_code;
    $data=get_cols_where_row(new Admin(),array("*"),array("com_code"=>$com_code,"id"=>$userid));
    if(empty($data)){
    return redirect()->route('admin.admins_accounts.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }  


$flag = delete(new Admins_stores(),array("admin_id"=>$userid,'id'=>$rowid,"com_code"=>$com_code));
if ($flag) {
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
 
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function ajax_search(Request $request)
{
if ($request->ajax()) {
  $com_code = auth()->user()->com_code;
$search_by_name = $request->search_by_name;
$permission_roles_id_search = $request->permission_roles_id_search;

if ($permission_roles_id_search == 'all') {
$field1 = "id";
$operator1 = ">";
$value1 = 0;
}else {
$field1 = "permission_roles_id";
$operator1 = "=";
$value1 = $permission_roles_id_search;
}


if ($search_by_name != '') {

$field2 = "name";
$operator2 = "like";
$value2 = "%{$search_by_name}%";

} else {
//true 
$field2 = "id";
$operator2 = ">";
$value2 = 0;
}


$data = Admin::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where('com_code', '=', $com_code)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    $info->permission_roles_name = Permission_rols::where('id', $info->permission_roles_id)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }
return view('admin.admins_accounts.ajax_search', ['data' => $data]);
}
}

}
