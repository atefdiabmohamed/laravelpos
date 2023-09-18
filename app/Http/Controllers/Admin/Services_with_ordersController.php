<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Account;
use App\Models\Services;
use App\Models\services_with_orders_details;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Http\Requests\Services_orders_request;
use App\Models\Supplier;
use App\Models\Suppliers_with_orders;
use App\Models\Customer;
use App\Models\Sales_invoices;
use App\Models\SalesReturn;
use App\Models\Delegate;
use App\Models\services_with_orders;
class Services_with_ordersController extends Controller
{

public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new services_with_orders(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->is_account_number==1){
$info->account_name = Account::where('account_number', $info->account_number)->value('name');
}
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
$accounts = get_cols_where(new Account(), array('account_number', 'name'), array('com_code' => $com_code,'is_parent'=>0), 'id', 'DESC');
return view('admin.services_with_orders.index', ['data' => $data, 'accounts' => $accounts]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$accounts = get_cols_where(new Account(), array('account_number', 'name'), array('com_code' => $com_code,'is_parent'=>0), 'id', 'DESC');
return view('admin.services_with_orders.create', ['accounts' => $accounts]);
}
public function store(Services_orders_request $request)
{
try {
$com_code = auth()->user()->com_code;
if($request->is_account_number==1){
$AccountData = get_cols_where_row(new Account(), array("id"), array("account_number" => $request->account_number, "com_code" => $com_code));
if (empty($AccountData)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات الحساب المحدد'])
->withInput();
}
}
if($request->order_type==1){
$row = get_cols_where_row_orderby(new services_with_orders(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC');
}else{
$row = get_cols_where_row_orderby(new services_with_orders(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>2), 'id', 'DESC');
}
if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}

$data_insert['order_date'] = $request->order_date;
$data_insert['is_account_number'] = $request->is_account_number;
$data_insert['order_type'] = $request->order_type;
if($request->is_account_number==1){
$data_insert['account_number'] = $request->account_number;
}else{
$data_insert['entity_name'] = $request->entity_name;
}
$data_insert['pill_type'] = $request->pill_type;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
insert(new services_with_orders(),$data_insert);
$id = get_field_value(new services_with_orders(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => $request->order_type));
return redirect()->route("admin.Services_orders.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function show($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
if($data['is_account_number']==1){
$data['account_name'] = Account::where('account_number', $data['account_number'])->value('name');
}
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}


$details = get_cols_where(new services_with_orders_details(), array("*"), array('services_with_orders_auto_serial' => $data['auto_serial'], 'order_type' => $data['order_type'], 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->service_name = Services::where('id', $info->service_id)->value('name');
$data['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by> 0 and $info->updated_by != null) {
$data['updated_by_admin'] = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view("admin.services_with_orders.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("is_approved","order_type"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$services = get_cols_where(new Services(), array("name", "id"), array('active' => 1, 'com_code' => $com_code,'type'=>$parent_pill_data['order_type']), 'id', 'DESC');
return view("admin.services_with_orders.load_add_new_itemdetails", ['parent_pill_data' => $parent_pill_data, 'services' => $services]);
}
}
}
}

public function add_new_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("is_approved", "order_date", "tax_value", "discount_value",'order_type','auto_serial',"id"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$data_insert['services_with_orders_auto_serial'] = $parent_pill_data['auto_serial'];
$data_insert['order_type'] = $parent_pill_data['order_type'];;
$data_insert['service_id'] = $request->services_id_add;
$data_insert['services_with_orders_id'] = $parent_pill_data['id'];
$data_insert['notes'] = $request->notes_add;
$data_insert['total'] = $request->total_add;
$data_insert['order_date'] = $parent_pill_data['order_date'];
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new services_with_orders_details(), $data_insert);
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new services_with_orders_details(), 'total', array("services_with_orders_auto_serial" =>$parent_pill_data['auto_serial'], 'order_type' => $parent_pill_data['order_type'], 'com_code' => $com_code));
$dataUpdateParent['total_services'] = $total_detials_sum;
$dataUpdateParent['total_befor_discount'] = $total_detials_sum + $parent_pill_data['tax_value'];
$dataUpdateParent['total_cost'] = $dataUpdateParent['total_befor_discount'] - $parent_pill_data['discount_value'];
$dataUpdateParent['updated_by'] = auth()->user()->id;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
update(new services_with_orders(), $dataUpdateParent, array( "com_code" => $com_code,"id" => $request->id_parent_pill));
echo json_encode("done");
}
}
}
}
}

public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("is_approved", "auto_serial",'order_type'), array("id" => $id, "com_code" => $com_code));
if (empty($parent_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($parent_pill_data['is_approved'] == 1) {
if (empty($parent_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
}
}
$flag = delete(new services_with_orders(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
delete(new services_with_orders_details(), array("services_with_orders_auto_serial" => $parent_pill_data['auto_serial'], "com_code" => $com_code, 'order_type' =>$parent_pill_data['order_type']));
return redirect()->route('admin.Services_orders.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}

$accounts = get_cols_where(new Account(), array('account_number', 'name'), array('com_code' => $com_code,'is_parent'=>0), 'id', 'DESC');
$Services_Added_Counter=get_count_where(new services_with_orders_details(),array('services_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>$data['order_type'],'com_code'=>$com_code));

return view('admin.services_with_orders.edit', ['data' => $data, 'accounts' => $accounts,'Services_Added_Counter'=>$Services_Added_Counter]);
}


public function update($id, Services_orders_request $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}

if($request->is_account_number==1){
    $accountData = get_cols_where_row(new Account(), array("account_number"), array("account_number" => $request->account_number, "com_code" => $com_code));
    if (empty($accountData)) {
    return redirect()->back()
    ->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات الحساب المالي المحدد'])
    ->withInput();
    }
}

$data_to_update['order_date'] = $request->order_date;
$data_to_update['is_account_number'] = $request->is_account_number;

$Services_Added_Counter=get_count_where(new services_with_orders_details(),array('services_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>$data['order_type'],'com_code'=>$com_code));
if($Services_Added_Counter==0){
    $data_to_update['order_type'] = $request->order_type;

}


if($request->is_account_number==1){
$data_to_update['account_number'] = $request->account_number;
$data_to_update['entity_name']="";
}else{
$data_to_update['entity_name'] = $request->entity_name;
$data_to_update['account_number'] = 0;
}
$data_to_update['pill_type'] = $request->pill_type;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new services_with_orders(), $data_to_update, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.Services_orders.show', $id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function reload_parent_pill(Request $request)
{
if ($request->ajax()) {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $request->id, "com_code" => $com_code));
    if (!empty($data)) {
        $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
        if($data['is_account_number']==1){
        $data['account_name'] = Account::where('account_number', $data['account_number'])->value('name');
        }
        if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
        $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
        }

    }
 
return view("admin.services_with_orders.reload_parent_pill", ['data' => $data]);
}
}

public function reload_itemsdetials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $request->id, "com_code" => $com_code));
if (!empty($data)) {
$details = get_cols_where(new services_with_orders_details(), array("*"), array('services_with_orders_auto_serial' => $data['auto_serial'], 'order_type' => $data['order_type'], 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
    foreach ($details as $info) {
    $info->service_name = Services::where('id', $info->service_id)->value('name');
    $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
    if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
    }
    }
    }
}
return view("admin.services_with_orders.reload_itemsdetials", ['data' => $data, 'details' => $details]);
}
}
public function delete_details($id, $parent_id)
{
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $parent_id, "com_code" => $com_code));
if (empty($parent_pill_data)) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($parent_pill_data['is_approved'] == 1) {
return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$item_row = services_with_orders_details::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {

/** update parent pill */
$total_detials_sum = get_sum_where(new services_with_orders_details(), 'total', array("services_with_orders_auto_serial" =>$parent_pill_data['auto_serial'], 'order_type' => $parent_pill_data['order_type'], 'com_code' => $com_code));
$dataUpdateParent['total_services'] = $total_detials_sum;
$dataUpdateParent['total_befor_discount'] = $total_detials_sum + $parent_pill_data['tax_value'];
$dataUpdateParent['total_cost'] = $dataUpdateParent['total_befor_discount'] - $parent_pill_data['discount_value'];
$dataUpdateParent['updated_by'] = auth()->user()->id;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
update(new services_with_orders(), $dataUpdateParent, array( "com_code" => $com_code,"id" => $parent_id));

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

public function load_edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$item_data_detials = get_cols_where_row(new services_with_orders_details(), array("*"), array("services_with_orders_auto_serial" => $parent_pill_data['auto_serial'], "com_code" => $com_code, 'order_type' => $parent_pill_data['order_type'], 'id' => $request->id));
$services = get_cols_where(new Services(), array("name", "id"), array('active' => 1, 'com_code' => $com_code,'type'=>$parent_pill_data['order_type']), 'id', 'DESC');
return view("admin.services_with_orders.load_edit_item_details", ['parent_pill_data' => $parent_pill_data, 'item_data_detials' => $item_data_detials, 'services' => $services]);
}
}
}
}

public function edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$data_to_update['service_id'] = $request->services_id;
$data_to_update['total'] = $request->total;
$data_to_update['notes'] = $request->notes;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
$data_to_update['com_code'] = $com_code;

$flag = update(new services_with_orders_details(), $data_to_update, array("id" => $request->id, 'com_code' => $com_code, 'order_type' => $parent_pill_data['order_type'], 'services_with_orders_auto_serial' => $parent_pill_data['auto_serial']));
if ($flag) {
/** update parent pill */

/** update parent pill */
$total_detials_sum = get_sum_where(new services_with_orders_details(), 'total', array("services_with_orders_auto_serial" =>$parent_pill_data['auto_serial'], 'order_type' => $parent_pill_data['order_type'], 'com_code' => $com_code));
$dataUpdateParent['total_services'] = $total_detials_sum;
$dataUpdateParent['total_befor_discount'] = $total_detials_sum + $parent_pill_data['tax_value'];
$dataUpdateParent['total_cost'] = $dataUpdateParent['total_befor_discount'] - $parent_pill_data['discount_value'];
$dataUpdateParent['updated_by'] = auth()->user()->id;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
update(new services_with_orders(), $dataUpdateParent, array( "com_code" => $com_code,"id" => $request->id_parent_pill));

echo json_encode("done");
}
}
}
}
}

public function load_modal_approve_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
//current user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
$counterDetails=get_count_where(new services_with_orders_details(),array('services_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>$data['order_type'],'com_code'=>$com_code));



return view("admin.services_with_orders.load_modal_approve_invoice", ['data' => $data, 'user_shift' => $user_shift,'counterDetails'=>$counterDetails]);
}
}
public function load_usershiftDiv(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parentordertype=$request->parentordertype;
//current user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
}

return view("admin.services_with_orders.load_usershiftDiv", ['user_shift' => $user_shift,'parentordertype'=>$parentordertype]);
}


//اعتماد وترحيل فاتورة خدمات 
function do_approve($id, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
$data = get_cols_where_row(new services_with_orders(), array("total_services", "is_approved", "id", "account_number","auto_serial","order_type","is_account_number","entity_name"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route("admin.Services_orders.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($data['is_approved'] == 1) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => "عفوا لايمكن اعتماد فاتورة معتمده من قبل !!"]);
}
$counterDetails=get_count_where(new services_with_orders_details(),array('services_with_orders_auto_serial'=>$data['auto_serial'],'order_type'=>$data['order_type'],'com_code'=>$com_code));
if ($counterDetails== 0) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => "عفوا لايمكن اعتماد الفاتورة قبل اضافة خدمات عليها !!!            "]);
}
$dataUpdateParent['tax_percent'] = $request['tax_percent'];
$dataUpdateParent['tax_value'] = $request['tax_value'];
$dataUpdateParent['total_befor_discount'] = $request['total_befor_discount'];
$dataUpdateParent['discount_type'] = $request['discount_type'];
$dataUpdateParent['discount_percent'] = $request['discount_percent'];
$dataUpdateParent['discount_value'] = $request['discount_value'];
$dataUpdateParent['total_cost'] = $request['total_cost'];
$dataUpdateParent['pill_type'] = $request['pill_type'];
if($data['is_account_number']==1){
    if($data['order_type']==1){
  $dataUpdateParent['money_for_account'] = $request['total_cost'] * (-1);
     }else{
        $dataUpdateParent['money_for_account'] = $request['total_cost'] ;

     }

}

$dataUpdateParent['is_approved'] = 1;
$dataUpdateParent['approved_by'] = auth()->user()->com_code;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
//first check for pill type sate cash
if ($request['pill_type'] == 1) {
if ($request['what_paid'] != $request['total_cost']) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => "عفوا يجب ان يكون المبلغ بالكامل مدفوع في حالة الفاتورة كاش !!"]);
}
}
//second  check for pill type sate agel
if ($request['pill_type'] == 2) {
if ($request['what_paid'] == $request['total_cost']) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => "عفوا يجب ان لايكون المبلغ بالكامل مدفوع في حالة الفاتورة اجل !!"]);
}
}
$dataUpdateParent['what_paid'] = $request['what_paid'];
$dataUpdateParent['what_remain'] = $request['what_remain'];
//thaird  check for what paid 
if ($request['what_paid'] > 0) {
if ($request['what_paid'] > $request['total_cost']) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => "عفوا يجب ان لايكون المبلغ المدفوع اكبر من اجمالي الفاتورة      !!"]);
}
//check for user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
//chehck if is empty
if (empty($user_shift)) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => " عفوا لاتملتك الان شفت خزنة مفتوح لكي تتمكن من اتمام عمليه الصرف"]);
}

if($data['order_type']==1){
//check for blance
if ($user_shift['balance'] < $request['what_paid']) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => " عفوا لاتملتك الان رصيد كافي بخزنة الصرف  لكي تتمكن من اتمام عمليه الصرف"]);
}

$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_exhcange"), array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
if (empty($treasury_date)) {
return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => " عفوا غير قادر علي الوصول الي بيانات الخزنة المطلوبة"]);
}

}else{
    $treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_collect"), array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
    if (empty($treasury_date)) {
    return redirect()->route("admin.Services_orders.show", $data['id'])->with(['error' => " عفوا غير قادر علي الوصول الي بيانات الخزنة المطلوبة"]);
    }


}


}





$flag = update(new services_with_orders(), $dataUpdateParent, array("id" => $id, "com_code" => $com_code, 'is_approved' => 0));
if ($flag) {

    if($data['is_account_number']==1){ 
        $account_type = Account::where(["account_number" => $data['account_number']])->value("account_type");

        if($account_type==2){
            $the_final_Balance=refresh_account_blance_supplier($data['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,false);
            }elseif($account_type==3){
            $the_final_Balance=refresh_account_blance_customer($data['account_number'],new Account(),new Customer(),new Treasuries_transactions(),new Sales_invoices(),new SalesReturn(),new services_with_orders(),false);
            }elseif ($account_type == 4) {
                $the_final_Balance =  refresh_account_blance_delegate($data['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),false);
            }
            else{
            $the_final_Balance=refresh_account_blance_General($data['account_number'],new Account(),new Treasuries_transactions(),new services_with_orders(),false);
            }



    }





//حركات  مختلفه
//first make treasuries_transactions  action if what paid >0
if ($request['what_paid'] > 0) {
//first get isal number with treasuries 
if($data['order_type']==1){
    $dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_exhcange'] + 1;
    $dataInsert_treasuries_transactions['mov_type'] = 27;
    $dataInsert_treasuries_transactions['money'] = $request['what_paid'] * (-1);
    if($data['is_account_number']==1){
    $dataInsert_treasuries_transactions['money_for_account'] = $request['what_paid'];
    $dataInsert_treasuries_transactions['account_number'] = $data["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
$dataInsert_treasuries_transactions['byan'] = "صرف نظير فاتورة خدمات مقدمة لنا  رقم الفاتورة" . $data['auto_serial'];

    }else{
        $dataInsert_treasuries_transactions['byan'] = "صرف نظير فاتورة خدمات مقدمة لنا  رقم الفاتورة" . $data['auto_serial']." من الجهة".$data['entity_name'];


    }
}else{

    $dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_collect'] + 1;
    $dataInsert_treasuries_transactions['mov_type'] = 28;
    $dataInsert_treasuries_transactions['money'] = $request['what_paid'];
if($data['is_account_number']==1){
    $dataInsert_treasuries_transactions['money_for_account'] = $request['what_paid']*(-1);
    $dataInsert_treasuries_transactions['account_number'] = $data["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
$dataInsert_treasuries_transactions['byan'] = "تحصيل نظير فاتورة خدمات نقدمها للغير  رقم الفاتورة" . $data['auto_serial'];

}else{
    $dataInsert_treasuries_transactions['byan'] = "تحصيل نظير نظير فاتورة خدمات نقدمها للغير  رقم الفاتورة" . $data['auto_serial']." من الجهة".$data['entity_name'];

}

}





$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert_treasuries_transactions['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert_treasuries_transactions['auto_serial'] = 1;
}

$dataInsert_treasuries_transactions['shift_code'] = $user_shift['shift_code'];
//Credit دائن
$dataInsert_treasuries_transactions['treasuries_id'] = $user_shift['treasuries_id'];
$dataInsert_treasuries_transactions['move_date'] = date("Y-m-d");

$dataInsert_treasuries_transactions['is_approved'] = 1;
$dataInsert_treasuries_transactions['the_foregin_key'] = $data["auto_serial"];
$dataInsert_treasuries_transactions['created_at'] = date("Y-m-Y H:i:s");
$dataInsert_treasuries_transactions['added_by'] = auth()->user()->id;
$dataInsert_treasuries_transactions['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert_treasuries_transactions);
if ($flag) {
    if($data['order_type']==1){
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_exhcange'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));


    }else{
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_collect'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));



    }



}
}
if($data['is_account_number']==1){
refresh_account_blance_General($data['account_number'],new Account(),new Treasuries_transactions(),true);
}

return redirect()->route("admin.Services_orders.show", $data['id'])->with(['success' => " تم اعتماد وترحيل الفاتورة بنجاح  "]);
}
}


public function ajax_search(Request $request)
{
if ($request->ajax()) {
  
$search_by_text = $request->search_by_text;
$account_number = $request->account_number;
$is_account_number = $request->is_account_number;
$order_date_form = $request->order_date_form;
$order_date_to = $request->order_date_to;
$searchbyradio = $request->searchbyradio;
$order_type= $request->order_type;
if ($account_number == 'all') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "account_number";
$operator1 = "=";
$value1 = $account_number;
}
if ($is_account_number == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "is_account_number";
$operator2 = "=";
$value2 = $is_account_number;
}
if ($order_date_form == '') {
//دائما  true
$field3 = "id";
$operator3 = ">";
$value3 = 0;
} else {
$field3 = "order_date";
$operator3 = ">=";
$value3 = $order_date_form;
}
if ($order_date_to == '') {
//دائما  true
$field4 = "id";
$operator4 = ">";
$value4 = 0;
} else {
$field4 = "order_date";
$operator4 = "<=";
$value4 = $order_date_to;
}
if ($search_by_text != '') {
if ($searchbyradio == 'auto_serial') {
$field5 = "auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
}elseif ($searchbyradio == 'account_number') {
    $field5 = "account_number";
    $operator5 = "=";
    $value5 = $search_by_text;
    }
else {
$field5 = "entity_name";
$operator5 = "=";
$value5 = $search_by_text;
}
} else {
//true 
$field5 = "id";
$operator5 = ">";
$value5 = 0;
}

if ($order_type == 'all') {
    //دائما  true
    $field6 = "id";
    $operator6 = ">";
    $value6 = 0;
    } else {
    $field6 = "order_type";
    $operator6 = "=";
    $value6 = $order_type;
    }

$data = services_with_orders::where($field1, $operator1, $value1)->
where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->
where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->
where($field6, $operator6, $value6)->
orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->is_account_number==1){
    $info->account_name = Account::where('account_number', $info->account_number)->value('name');
    }
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }
return view('admin.services_with_orders.ajax_search', ['data' => $data]);
}
}


public function printsaleswina4($id,$size){

    try {
    $com_code = auth()->user()->com_code;
    $invoice_data = get_cols_where_row(new services_with_orders(), array("*"), array("id" => $id, "com_code" => $com_code));
    if (empty($invoice_data)) {
    return redirect()->route('admin.Services_orders.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
   
    $invoice_data['added_by_admin'] = Admin::where('id', $invoice_data['added_by'])->value('name');
    if($invoice_data['is_account_number']==1){
    $invoice_data['account_name'] = Account::where('account_number', $invoice_data['account_number'])->value('name');
    }
  
    $invoices_details = get_cols_where(new services_with_orders_details(), array("*"), array('services_with_orders_auto_serial' => $invoice_data['auto_serial'], 'order_type' => $invoice_data['order_type'], 'com_code' => $com_code), 'id', 'DESC');
    if (!empty($invoices_details)) {
        foreach ($invoices_details as $info) {
        $info->service_name = Services::where('id', $info->service_id)->value('name');
        $data['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
        if ($info->updated_by> 0 and $info->updated_by != null) {
        $data['updated_by_admin'] = Admin::where('id', $info->updated_by)->value('name');
        }
        }
        }


   
    $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
    
    if($size=="A4"){
        return view('admin.services_with_orders.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'invoices_details'=>$invoices_details]);
    }else{
        return view('admin.services_with_orders.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'invoices_details'=>$invoices_details]);
    
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
    }
    



}