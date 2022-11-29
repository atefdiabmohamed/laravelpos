<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Account;
use App\Models\Services;
use App\Models\services_with_orders;
use App\Models\services_with_orders_details;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Http\Requests\Services_orders_request;
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
return redirect()->route("admin.Services_orders.index", $id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
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
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
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
$parent_pill_data = get_cols_where_row(new services_with_orders(), array("is_approved", "order_date", "tax_value", "discount_value",'order_type','auto_serial'), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$data_insert['services_with_orders_auto_serial'] = $parent_pill_data['auto_serial'];
$data_insert['order_type'] = $parent_pill_data['order_type'];;
$data_insert['service_id'] = $request->services_id_add;
$data_insert['notes_add'] = $request->notes_add;
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
}