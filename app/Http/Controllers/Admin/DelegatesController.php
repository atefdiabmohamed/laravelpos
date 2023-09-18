<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delegate;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Admin_panel_setting;
use App\Http\Requests\DelegatesRequestAdd;
use App\Http\Requests\DelegatesUpdateRequest;
class DelegatesController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Delegate(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.delegates.index', ['data' => $data]);
}
public function create()
{
return view('admin.delegates.create');
}
public function store(DelegatesRequestAdd $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits for name
$checkExists_name = get_cols_where_row(new Delegate(), array("id"), array('name' => $request->name, 'com_code' => $com_code));
if (!empty($checkExists_name)) {
return redirect()->back()
->with(['error' => 'عفوا اسم المندوب مسجل من قبل'])
->withInput();
}
if ($request->percent_type == 2) {
if ($request->percent_salaes_commission_kataei > 100) {
return redirect()->back()
->with(['error' => 'عفوا عمولة المندوب بالمبيعات قطاعي لايمكن ان تتخطي  100 %'])
->withInput();
}
if ($request->percent_salaes_commission_nosjomla > 100) {
return redirect()->back()
->with(['error' => 'عفوا عمولة المندوب بالمبيعات نص جملة لايمكن ان تتخطي  100 %'])
->withInput();
}
if ($request->percent_salaes_commission_jomla > 100) {
return redirect()->back()
->with(['error' => 'عفوا عمولة المندوب بالمبيعات  الجملة لايمكن ان تتخطي  100 %'])
->withInput();
}
if ($request->percent_collect_commission > 100) {
return redirect()->back()
->with(['error' => 'عفوا عمولة المندوب بتحصيل الاجل لايمكن ان تتخطي  100 %'])
->withInput();
}
}
//set delegate_code
$row = get_cols_where_row_orderby(new Delegate(), array("delegate_code"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['delegate_code'] = $row['delegate_code'] + 1;
} else {
$data_insert['delegate_code'] = 1;
}
//set account number نديله رقم حساب مالي بالشجرة المحاسبية
$row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['account_number'] = $row['account_number'] + 1;
} else {
$data_insert['account_number'] = 1;
}
$data_insert['name'] = $request->name;
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
$data_insert['percent_type'] = $request->percent_type;
$data_insert['percent_salaes_commission_kataei'] = $request->percent_salaes_commission_kataei;
$data_insert['percent_salaes_commission_nosjomla'] = $request->percent_salaes_commission_nosjomla;
$data_insert['percent_salaes_commission_jomla'] = $request->percent_salaes_commission_jomla;
$data_insert['percent_collect_commission'] = $request->percent_collect_commission;
$data_insert['phones'] = $request->phones;
$data_insert['current_balance'] = $data_insert['start_balance'];
$data_insert['notes'] = $request->notes;
$data_insert['active'] = $request->active;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new Delegate(), $data_insert);
if ($flag) {
//insert into accounts حنفتح ليه حساب مالي بالشجرة المحاسبية
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
$delegates_parent_account_number = get_field_value(new Admin_panel_setting(), "delegate_parent_account_number", array('com_code' => $com_code));
$data_insert_account['notes'] = $request->notes;
//المناديب الاب
$data_insert_account['parent_account_number'] = $delegates_parent_account_number;
$data_insert_account['is_parent'] = 0;
$data_insert_account['account_number'] = $data_insert['account_number'];
$data_insert_account['account_type'] = 4;
$data_insert_account['active'] = $request->active;
$data_insert_account['added_by'] = auth()->user()->id;
$data_insert_account['created_at'] = date("Y-m-d H:i:s");
$data_insert_account['date'] = date("Y-m-d");
$data_insert_account['com_code'] = $com_code;
$data_insert_account['other_table_FK'] = $data_insert['delegate_code'];
$flag = insert(new Account(), $data_insert_account);
}
return redirect()->route('admin.delegates.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Delegate(), array("*"), array("id" => $id, "com_code" => $com_code));
return view('admin.delegates.edit', ['data' => $data]);
}
public function update($id, DelegatesUpdateRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Delegate(), array("id", "account_number", "delegate_code"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.customers.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists = Delegate::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الحساب مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['phones'] = $request->phones;
$data_to_update['address'] = $request->address;
$data_to_update['percent_type'] = $request->percent_type;
$data_to_update['percent_salaes_commission_kataei'] = $request->percent_salaes_commission_kataei;
$data_to_update['percent_salaes_commission_nosjomla'] = $request->percent_salaes_commission_nosjomla;
$data_to_update['percent_salaes_commission_jomla'] = $request->percent_salaes_commission_jomla;
$data_to_update['percent_collect_commission'] = $request->percent_collect_commission;
$data_to_update['notes'] = $request->notes;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$flag = update(new Delegate(), $data_to_update, array('id' => $id, 'com_code' => $com_code));
if ($flag) {
$data_to_update_account['name'] = $request->name;
$data_to_update_account['updated_by'] = auth()->user()->id;
$data_to_update_account['updated_at'] = date("Y-m-d H:i:s");
$data_to_update_account['active'] = $request->active;
$flag = update(new Account(), $data_to_update_account, array('account_number' => $data['account_number'], 'other_table_FK' => $data['delegate_code'], 'com_code' => $com_code, 'account_type' => 4));
}
return redirect()->route('admin.delegates.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
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
if ($searchbyradio == 'delegate_code') {
$field1 = "delegate_code";
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




$data = Delegate::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
//General mirror 
$mirror['credit_sum']=Delegate::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where("current_balance", "<", 0)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->sum('current_balance');
$mirror['debit_sum']=Delegate::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where("current_balance", ">", 0)->where($field3, $operator3, $value3)->where(['com_code' => $com_code])->sum('current_balance');
$mirror['net']=$mirror['credit_sum']+$mirror['debit_sum'];
return view('admin.delegates.ajax_search', ['data' => $data,'mirror'=>$mirror]);
}
}
public function show(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$id=$request->id;
$data = get_cols_where_row(new Delegate(), array("*"), array("id" => $id, "com_code" => $com_code));
if(!empty($data)){
$data['added_by_admin']=get_field_value(new Admin(),"name",array("id"=>$data['added_by'],'com_code'=>$com_code));
if($data['updated_by']>0){
$data['updated_by_admin']=get_field_value(new Admin(),"name",array("id"=>$data['updated_by'],'com_code'=>$com_code));
}
}
return view('admin.delegates.show',['data'=>$data]);
}
}
}