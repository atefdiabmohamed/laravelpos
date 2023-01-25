<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admins_treasuries;
use App\Models\Treasuries;
class AdminController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Admin(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.admins_accounts.index', ['data' => $data]);
}
public function details($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Admin(), array("*"), array("id" => $id, 'com_code' => $com_code));
if (empty($data)) {
return redirect()->route('admin.admins_accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}
$treasuries = get_cols_where(new Treasuries(), array("id", "name"), array("active" => 1, "com_code" => $com_code), 'id', 'ASC');
$admins_treasuries = get_cols_where(new Admins_treasuries(), array("*"), array("admin_id" => $id, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($admins_treasuries)) {
foreach ($admins_treasuries as $info) {
$info->name = Treasuries::where('id', $info->treasuries_id)->value('name');
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view("admin.admins_accounts.details", ['data' => $data, 'admins_treasuries' => $admins_treasuries, 'treasuries' => $treasuries]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function Add_treasuries_To_Admin($id,Request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Admin(), array("*"), array("id" => $id, 'com_code' => $com_code));
if (empty($data)) {
return redirect()->route('admin.admins_accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
//check if not exists
$admins_treasuries_exsits = get_cols_where_row(new Admins_treasuries(), array("id"), array("admin_id" => $id,"treasuries_id"=>$request->treasuries_id, 'com_code' => $com_code));
if (!empty($admins_treasuries_exsits)) {
return redirect()->route('admin.admins_accounts.details',$id)->with(['error' => 'عفوا هذه الخزنة بالفعل مضافة من قبل لهذا المستخدم !!!']);
}
$data_insert['admin_id'] = $id;
$data_insert['treasuries_id'] = $request->treasuries_id;
$data_insert['active'] = 1;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['added_by'] = auth()->user()->id;
$data_insert['com_code'] = $com_code;
$data_insert['date'] = date("Y-m-d");
$flag=insert(new Admins_treasuries(),$data_insert);
if($flag){
return redirect()->route('admin.admins_accounts.details',$id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->route('admin.admins_accounts.details',$id)->with(['error' => 'عفوا حدث خطأ ما من فضلك حاول مرة اخري !!!']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
}