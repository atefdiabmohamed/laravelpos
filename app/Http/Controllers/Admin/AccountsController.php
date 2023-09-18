<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Account;
use App\Models\Account_types;
use App\Models\Admin;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AccountsRequest;
use App\Http\Requests\AccountsRequestUpdate;
class AccountsController extends Controller
{
public function index()
{
    
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Account(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
$info->account_types_name = Account_types::where('id', $info->account_type)->value('name');
$info->relatediternalaccounts = Account_types::where('id', $info->account_type)->value('relatediternalaccounts');
if ($info->is_parent == 0) {
$info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
} else {
$info->parent_account_name = "لايوجد";
}
}
}
$account_types = get_cols_where(new Account_types(), array("id", "name"), array("active" => 1), 'id', 'ASC');
return view('admin.accounts.index', ['data' => $data, 'account_types' => $account_types]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$account_types = get_cols_where(new Account_types(), array("id", "name"), array("active" => 1, "relatediternalaccounts" => 0), 'id', 'ASC');
$parent_accounts = get_cols_where(new Account(), array("account_number", "name"), array("is_parent" => 1, "com_code" => $com_code), 'id', 'ASC');
return view('admin.accounts.create', ['account_types' => $account_types, 'parent_accounts' => $parent_accounts]);
}
public function store(AccountsRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits for name
$checkExists_name = get_cols_where_row(new Account(), array("id"), array('name' => $request->name, 'com_code' => $com_code));
if (!empty($checkExists_name)) {
return redirect()->back()
->with(['error' => 'عفوا اسم الحساب مسجل من قبل'])
->withInput();
}
//set account number
$row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['account_number'] = $row['account_number'] + 1;
} else {
$data_insert['account_number'] = 1;
}
$data_insert['name'] = $request->name;
$data_insert['account_type'] = $request->account_type;
$data_insert['is_parent'] = $request->is_parent;
if ($data_insert['is_parent'] == 0) {
$data_insert['parent_account_number'] = $request->parent_account_number;
}
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
Account::create($data_insert);
return redirect()->route('admin.accounts.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Account(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$relatediternalaccounts = Account_types::where('id', $data['account_type'])->value('relatediternalaccounts');
if ($relatediternalaccounts == 1) {
return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا لايمكن تحديث هذا الحساب الي من شاشته الخاصه حسب نوعه']);
}
$account_types = get_cols_where(new Account_types(), array("id", "name"), array("active" => 1), 'id', 'ASC');
$parent_accounts = get_cols_where(new Account(), array("account_number", "name"), array("is_parent" => 1, "com_code" => $com_code), 'id', 'ASC');
return view('admin.accounts.edit', ['account_types' => $account_types, 'parent_accounts' => $parent_accounts, 'data' => $data]);
}
public function update($id, AccountsRequestUpdate $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Account(), array("id", "account_number", "other_table_FK", "account_type"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$relatediternalaccounts = Account_types::where('id', $data['account_type'])->value('relatediternalaccounts');
if ($relatediternalaccounts == 1) {
return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا لايمكن تحديث هذا الحساب الي من شاشته الخاصه حسب نوعه']);
}
$checkExists = Account::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الحساب مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['account_type'] = $request->account_type;
$data_to_update['is_parent'] = $request->is_parent;
if ($data_to_update['is_parent'] == 0) {
$data_to_update['parent_account_number'] = $request->parent_account_number;
}
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$flag =  update(new Account(), $data_to_update, array('id' => $id, 'com_code' => $com_code));
return redirect()->route('admin.accounts.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$item_row = get_cols_where_row(new Account(), array("name"), array("id" => $id, "com_code" => $com_code));
if (!empty($item_row)) {
$flag = delete(new Account(), ["id" => $id, "com_code" => $com_code]);
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
$search_by_text = $request->search_by_text;
$is_parent = $request->is_parent;
$account_type = $request->account_type;
$active_search = $request->active_search;
$searchbyradio = $request->searchbyradio;
if ($is_parent == 'all') {
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "is_parent";
$operator1 = "=";
$value1 = $is_parent;
}
if ($account_type == 'all') {
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "account_type";
$operator2 = "=";
$value2 = $account_type;
}
if ($search_by_text != '') {
if ($searchbyradio == 'account_number') {
$field3 = "account_number";
$operator3 = "=";
$value3 = $search_by_text;
} else {
$field3 = "name";
$operator3 = "like";
$value3 = "%{$search_by_text}%";
}
} else {
//true 
$field3 = "id";
$operator3 = ">";
$value3 = 0;
}
if ($active_search == 'all') {
$field4 = "id";
$operator4 = ">";
$value4 = 0;
} else {
$field4 = "active";
$operator4 = "=";
$value4 = $active_search;
}
$data = Account::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
$info->account_types_name = Account_types::where('id', $info->account_type)->value('name');
$info->relatediternalaccounts = Account_types::where('id', $info->account_type)->value('relatediternalaccounts');
if ($info->is_parent == 0) {
$info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
} else {
$info->parent_account_name = "لايوجد";
}
}
}
return view('admin.accounts.ajax_search', ['data' => $data]);
}
}
}
