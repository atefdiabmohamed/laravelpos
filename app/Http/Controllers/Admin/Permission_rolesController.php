<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission_rols;
use App\Models\Permission_main_menues;
use App\Models\Permission_roles_sub_menu;
use App\Models\Permission_sub_menues_actions;
use App\Models\Permission_roles_main_menus;
use App\Models\Admin;
use App\Http\Requests\Permission_rolesRequest;
use App\Models\Permission_roles_sub_menues_actions;
use App\Models\Permission_sub_menues;
class Permission_rolesController extends Controller
{
public function index()
{
$data = Permission_rols::select()->orderby('id', 'ASC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.permission_roles.index', ['data' => $data]);
}
public function create()
{
return view('admin.permission_roles.create');
}
public function store(Permission_rolesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits
$checkExists = Permission_rols::where(['name' => $request->name, 'com_code' => $com_code])->first();
if ($checkExists == null) {
$data['name'] = $request->name;
$data['active'] = $request->active;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
Permission_rols::create($data);
return redirect()->route('admin.permission_roles.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا اسم الدور  مسجل من قبل'])
->withInput();
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$data = Permission_rols::select()->find($id);
return view('admin.permission_roles.edit', ['data' => $data]);
}
public function update($id, Permission_rolesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = Permission_rols::select()->find($id);
if (empty($data)) {
return redirect()->route('admin.permission_roles.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists = Permission_rols::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الصلاحية مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
Permission_rols::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
return redirect()->route('admin.permission_roles.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function details($id){
try{
$com_code=auth()->user()->com_code;
$data=get_cols_where_row(new Permission_rols(),array("*"),array("com_code"=>$com_code,"id"=>$id));
if(empty($data)){
return redirect()->route('admin.permission_roles.index')->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin']=Admin::where('id',$data['added_by'])->value('name');    
if($data['updated_by']>0 and $data['updated_by']!=null){
$data['updated_by_admin']=Admin::where('id',$data['updated_by'])->value('name');    
}
$Permission_main_menues=get_cols_where(new Permission_main_menues(),array("id",'name'),array("active"=>1,"com_code"=>$com_code));      
$permission_roles_main_menus=get_cols_where(new Permission_roles_main_menus(),array("*"),array("com_code"=>$com_code,"permission_roles_id"=>$id));
if(!empty($permission_roles_main_menus)){
foreach($permission_roles_main_menus as $info){
$info->permission_main_menues_name=get_field_value(new Permission_main_menues(),"name",array("com_code"=>$com_code,"id"=>$info->permission_main_menues_id));   
$info->added_by_admin=Admin::where('id',$info->added_by)->value('name');    

$info->permission_roles_sub_menu=get_cols_where(new Permission_roles_sub_menu(),array("*"),array("permission_roles_main_menus_id"=>$info->id));
if(!empty($info->permission_roles_sub_menu)){
    foreach($info->permission_roles_sub_menu as $sub){
        $sub->permission_sub_menues_name=get_field_value(new Permission_sub_menues(),"name",array("com_code"=>$com_code,"id"=>$sub->permission_sub_menues_id));   
        $sub->added_by_admin=Admin::where('id',$sub->added_by)->value('name'); 
        
        $sub->permission_roles_sub_menues_actions=get_cols_where(new Permission_roles_sub_menues_actions(),array("*"),array("permission_roles_sub_menu_id"=>$sub->id));
        if(!empty($sub->permission_roles_sub_menues_actions)){
            foreach($sub->permission_roles_sub_menues_actions as $action){
                $action->permission_sub_menues_actions_name=get_field_value(new Permission_sub_menues_actions(),"name",array("com_code"=>$com_code,"id"=>$action->permission_sub_menues_actions_id));   
            }
        }


        

    }
}


}
}
return view("admin.permission_roles.details",['data'=>$data,'Permission_main_menues'=>$Permission_main_menues,'permission_roles_main_menus'=>$permission_roles_main_menus]);
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()]);
}
}

public function Add_permission_main_menues($id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = Permission_rols::select()->find($id);
if (empty($data)) {
return redirect()->route('admin.permission_roles.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$permission_main_menues_ids=$request->permission_main_menues_id;
if(empty($permission_main_menues_ids)){
return redirect()->route('admin.permission_roles.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
foreach($permission_main_menues_ids as $info){
$dataToInsert['com_code']=$com_code;
$dataToInsert['permission_roles_id']=$id;
$dataToInsert['permission_main_menues_id']=$info;
$checkExists = get_cols_where_row(new Permission_roles_main_menus(),array("id"),$dataToInsert);
if(empty($checkExists)){
$dataToInsert['added_by'] = auth()->user()->id;
$dataToInsert['created_at'] = date("Y-m-d H:i:s");
insert(new Permission_roles_main_menus(),$dataToInsert);
}
}
return redirect()->route('admin.permission_roles.details',$id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function delete_permission_main_menues($id)
{
try {
$item_row = Permission_roles_main_menus::find($id);
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



public function delete_permission_sub_menues($id)
{
try {
$item_row = Permission_roles_sub_menu::find($id);
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

public function delete_permission_sub_menues_actions($id)
{
try {
$item_row = Permission_roles_sub_menues_actions::find($id);
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


public function load_add_permission_roles_sub_menu(Request $request){
if($request->ajax()){
$com_code = auth()->user()->com_code;        
$permission_roles_main_menus=get_cols_where_row(new Permission_roles_main_menus(),array("id","permission_main_menues_id"),array("id"=>$request->id,'com_code'=>$com_code));
$permission_sub_menues="";
if(!empty($permission_roles_main_menus)){
$permission_sub_menues=get_cols_where(new Permission_sub_menues(),array("id","name"),array("com_code"=>$com_code,'permission_main_menues_id'=>$permission_roles_main_menus['permission_main_menues_id']),'id','ASC');
}
return view('admin.permission_roles.load_add_permission_roles_sub_menu', ['permission_roles_main_menus' => $permission_roles_main_menus,'permission_sub_menues'=>$permission_sub_menues]);
}
}

public function load_add_permission_roles_sub_menues_actions(Request $request){
    if($request->ajax()){
    $com_code = auth()->user()->com_code;        
    $permission_roles_sub_menu=get_cols_where_row(new Permission_roles_sub_menu(),array("id","permission_sub_menues_id"),array("id"=>$request->id));
    $permission_sub_menues_actions="";
    if(!empty($permission_roles_sub_menu)){
    $permission_sub_menues_actions=get_cols_where(new Permission_sub_menues_actions(),array("id","name"),array("com_code"=>$com_code,'permission_sub_menues_id'=>$permission_roles_sub_menu['permission_sub_menues_id']),'id','ASC');
    }
    return view('admin.permission_roles.load_add_permission_roles_sub_menues_actions', ['permission_roles_sub_menu' => $permission_roles_sub_menu,'permission_sub_menues_actions'=>$permission_sub_menues_actions]);
    }
    }



public function add_permission_roles_sub_menu($permission_roles_main_menus_id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = Permission_roles_main_menus::select("*")->find($permission_roles_main_menus_id);
if (empty($data)) {
return redirect()->back();

}

$permission_sub_menues_id=$request->permission_sub_menues_id;
if(empty($permission_sub_menues_id)){
    return redirect()->back()->with(['error'=>'من فضلك اختر القوائم اولا']);
}
foreach($permission_sub_menues_id as $info){

$dataToInsert['permission_roles_main_menus_id']=$permission_roles_main_menus_id;
$dataToInsert['permission_sub_menues_id']=$info;
$dataToInsert['permission_roles_id']=$data['permission_roles_id'];
$checkExists = get_cols_where_row(new Permission_roles_sub_menu(),array("id"),$dataToInsert);
if(empty($checkExists)){
$dataToInsert['added_by'] = auth()->user()->id;
$dataToInsert['created_at'] = date("Y-m-d H:i:s");
insert(new Permission_roles_sub_menu(),$dataToInsert);
}
}
return redirect()->back()->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}




public function add_permission_roles_sub_menues_actions($permission_roles_sub_menu_id ,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = Permission_roles_sub_menu::select("*")->find($permission_roles_sub_menu_id );
if (empty($data)) {
return redirect()->back();

}

$permission_sub_menues_actions_id=$request->permission_sub_menues_actions_id;
if(empty($permission_sub_menues_actions_id)){
    return redirect()->back()->with(['error'=>'من فضلك اختر الصلاحيات اولا']);
}
foreach($permission_sub_menues_actions_id as $info){

$dataToInsert['permission_roles_sub_menu_id']=$permission_roles_sub_menu_id;
$dataToInsert['permission_sub_menues_actions_id']=$info;
$dataToInsert['permission_roles_id']=$data['permission_roles_id'];
$checkExists = get_cols_where_row(new Permission_roles_sub_menues_actions(),array("id"),$dataToInsert);
if(empty($checkExists)){
$dataToInsert['added_by'] = auth()->user()->id;
$dataToInsert['created_at'] = date("Y-m-d H:i:s");
insert(new Permission_roles_sub_menues_actions(),$dataToInsert);
}
}
return redirect()->back()->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}



}