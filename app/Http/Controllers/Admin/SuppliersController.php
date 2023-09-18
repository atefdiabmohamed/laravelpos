<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\Account;
use App\Models\SupplierCategories;
use App\Models\Supplier;
use App\Models\Admin_panel_setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\supplier_request;
use App\Http\Requests\SupplierUpdateRequest;
class SuppliersController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Supplier(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->suppliers_categories_name = SupplierCategories::where('id', $info->suppliers_categories_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.suppliers.index', ['data' => $data]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$suppliers_categories = get_cols_where(new SupplierCategories(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('admin.suppliers.create', ['suppliers_categories' => $suppliers_categories]);
}
public function store(supplier_request $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits for name
$checkExists_name = get_cols_where_row(new Supplier(), array("id"), array('name' => $request->name, 'com_code' => $com_code));
if (!empty($checkExists_name)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المورد مسجل من قبل'])
->withInput();
}
//set customer code
$row = get_cols_where_row_orderby(new Supplier(), array("suuplier_code"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['suuplier_code'] = $row['suuplier_code'] + 1;
} else {
$data_insert['suuplier_code'] = 1;
}
//set account number
$row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['account_number'] = $row['account_number'] + 1;
} else {
$data_insert['account_number'] = 1;
}
$data_insert['name'] = $request->name;
$data_insert['phones'] = $request->phones;
$data_insert['suppliers_categories_id'] = $request->suppliers_categories_id;
$data_insert['address'] = $request->address;
$data_insert['start_balance_status'] = $request->start_balance_status;
if ($data_insert['start_balance_status'] == 1) {
//credit
$data_insert['start_balance'] = $request->start_balance * (-1);
} elseif ($data_insert['start_balance_status'] == 2) {
//debit
$data_insert['start_balance'] = $request->start_balance;
if ($data_insert['start_balance'] < 0) {
$data_insert['start_balance'] = $data_insert['start_balance'] * (-1);
}
} elseif ($data_insert['start_balance_status'] == 3) {
//balanced
$data_insert['start_balance'] = 0;
} else {
$data_insert['start_balance_status'] = 3;
$data_insert['start_balance'] = 0;
}
$data_insert['current_balance'] = $data_insert['start_balance'];
$data_insert['notes'] = $request->notes;
$data_insert['active'] = $request->active;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new Supplier(), $data_insert);
if ($flag) {
//insert into accounts  بتفح سجل ليه بالشجرة المحاسبية
$data_insert_account['name'] = $request->name;
$data_insert_account['start_balance_status'] = $request->start_balance_status;
if ($data_insert_account['start_balance_status'] == 1) {
//credit
$data_insert_account['start_balance'] = $request->start_balance * (-1);
} elseif ($data_insert_account['start_balance_status'] == 2) {
//debit
$data_insert_account['start_balance'] = $request->start_balance;
if ($data_insert_account['start_balance'] < 0) {
$data_insert_account['start_balance'] = $data_insert_account['start_balance'] * (-1);
}
} elseif ($data_insert_account['start_balance_status'] == 3) {
//balanced
$data_insert_account['start_balance'] = 0;
} else {
$data_insert_account['start_balance_status'] = 3;
$data_insert_account['start_balance'] = 0;
}
$data_insert_account['current_balance'] = $data_insert_account['start_balance'];
$suppliers_parent_account_number = get_field_value(new Admin_panel_setting(), "suppliers_parent_account_number", array('com_code' => $com_code));
$data_insert_account['notes'] = $request->notes;
$data_insert_account['parent_account_number'] = $suppliers_parent_account_number;
$data_insert_account['is_parent'] = 0;
$data_insert_account['account_number'] = $data_insert['account_number'];
$data_insert_account['account_type'] = 2;
$data_insert_account['active'] = $request->active;
$data_insert_account['added_by'] = auth()->user()->id;
$data_insert_account['created_at'] = date("Y-m-d H:i:s");
$data_insert_account['date'] = date("Y-m-d");
$data_insert_account['com_code'] = $com_code;
$data_insert_account['other_table_FK'] = $data_insert['suuplier_code'];
$flag = insert(new Account(), $data_insert_account);
}
return redirect()->route('admin.supplier.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Supplier(), array("*"), array("id" => $id, "com_code" => $com_code));
$suppliers_categories = get_cols_where(new SupplierCategories(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
return view('admin.suppliers.edit', ['data' => $data, 'suppliers_categories' => $suppliers_categories]);
}
public function update($id, SupplierUpdateRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Supplier(), array("id", "account_number", "suuplier_code"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.supplier.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists = Supplier::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الحساب مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['phones'] = $request->phones;
$data_to_update['address'] = $request->address;
$data_to_update['notes'] = $request->notes;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$flag = update(new Supplier(), $data_to_update, array('id' => $id, 'com_code' => $com_code));
if ($flag) {
$data_to_update_account['name'] = $request->name;
$data_to_update_account['active'] = $request->active;
$data_to_update_account['updated_by'] = auth()->user()->id;
$data_to_update_account['updated_at'] = date("Y-m-d H:i:s");
$flag = update(new Account(), $data_to_update_account, array('account_number' => $data['account_number'], 'other_table_FK' => $data['suuplier_code'], 'com_code' => $com_code, 'account_type' => 2));
}
return redirect()->route('admin.supplier.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$item_row = get_cols_where_row(new Supplier(), array("name"), array("id" => $id, "com_code" => $com_code));
if (!empty($item_row)) {
$flag = delete(new Supplier(), ["id" => $id, "com_code" => $com_code]);
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
public function ajax_search(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$search_by_text = $request->search_by_text;
$searchbyradio = $request->searchbyradio;
$searchByBalanceStatus = $request->searchByBalanceStatus;
$searchByactiveStatus = $request->searchByactiveStatus;
$mirror['searchByBalanceStatus']=$searchByBalanceStatus ;



if ($search_by_text != '') {
if ($searchbyradio == 'suuplier_code') {
$field1 = "suuplier_code";
$operator1 = "=";
$value1 = $search_by_text;
} elseif ($searchbyradio == 'account_number') {
$field1 = "account_number";
$operator1 = "=";
$value1 = $search_by_text;
} else {
$field1 = "name";
$operator1 = "like";
$value1 = "%{$search_by_text}%";
}
} else {
//true 
$field1 = "id";
$operator1 = ">";
$value1 = 0;
}


if($searchByBalanceStatus=="all"){
    $field2 = "id";
    $operator2 = ">";
    $value2 = 0;
}else{
   if($searchByBalanceStatus==1){
    $field2 = "current_balance";
    $operator2 = "<";
    $value2 = 0;

   }elseif($searchByBalanceStatus==2){
    $field2 = "current_balance";
    $operator2 = ">";
    $value2 = 0;
}else{
    $field2 = "current_balance";
    $operator2 = "=";
    $value2 = 0;
}

}

if($searchByactiveStatus=="all"){
    $field3 = "id";
    $operator3 = ">";
    $value3 = 0;
}else{
  
    $field3 = "active";
    $operator3 = "=";
    $value3 = $searchByactiveStatus;
}



$data = Supplier::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->suppliers_categories_name = SupplierCategories::where('id', $info->suppliers_categories_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
//General mirror 
$mirror['credit_sum']=Supplier::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where("current_balance", "<", 0)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->sum('current_balance');
$mirror['debit_sum']=Supplier::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where("current_balance", ">", 0)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->sum('current_balance');
$mirror['net']=$mirror['credit_sum']+$mirror['debit_sum'];
return view('admin.suppliers.ajax_search', ['data' => $data,'mirror'=>$mirror]);
}
}
}