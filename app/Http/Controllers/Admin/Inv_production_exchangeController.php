<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Inv_production_exchange;
use App\Models\Inv_production_exchange_details;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Store;
use App\Models\Inv_itemcard_movements;
use App\Models\Account;
use App\Models\Inv_production_lines;
use App\Models\Admin_panel_setting;
use App\Models\Inv_itemcard_batches;
use App\Models\Inv_production_order;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Models\services_with_orders;
use App\Models\inv_production_receive;

use App\Http\Requests\Inv_production_exchangeRequest;
use App\Http\Requests\inv_production_exchangeUpRequest;
use Illuminate\Http\Request;
class Inv_production_exchangeController extends Controller
{
public function index()
{ 
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Inv_production_exchange(), array("*"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->production_lines_name = Inv_production_lines::where('production_lines_code', $info->production_lines_code)->value('name');
$info->store_name = Store::where('id', $info->store_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
$Inv_production_lines = get_cols_where(new Inv_production_lines(), array('production_lines_code', 'name'), array('com_code' => $com_code), 'id', 'ASC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'ASC');
return view('admin.inv_production_exchange.index', ['data' => $data, 'Inv_production_lines' => $Inv_production_lines, 'stores' => $stores]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$Inv_production_lines = get_cols_where(new Inv_production_lines(), array('production_lines_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'ASC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
$Inv_production_order = get_cols_where(new Inv_production_order(), array( 'auto_serial'), array('com_code' => $com_code, 'is_closed' => 0,'is_approved'=>1), 'id', 'DESC');
return view('admin.inv_production_exchange.create', ['Inv_production_lines' => $Inv_production_lines, 'stores' => $stores,'Inv_production_order'=>$Inv_production_order]);
}

public function store(Inv_production_exchangeRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$Inv_production_order_data = get_cols_where_row(new Inv_production_order(), array("is_approved","is_closed"), array("auto_serial" => $request->inv_production_order_auto_serial, "com_code" => $com_code));
if (empty($Inv_production_order_data)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات أمر التشغيل  المحدد'])
->withInput();
}
if($Inv_production_order_data['is_approved']==0){
return redirect()->back()
->with(['error' => 'عفوا  امر التشغيل المحدد غير معتمد !!'])
->withInput();  
}
if($Inv_production_order_data['is_closed']==1){
return redirect()->back()
->with(['error' => 'عفوا  امر التشغيل المحدد  مغلق ومؤرشف !!'])
->withInput();  
}
$Inv_production_line_data = get_cols_where_row(new Inv_production_lines(), array("account_number"), array("production_lines_code" => $request->production_lines_code, "com_code" => $com_code));
if (empty($Inv_production_line_data)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات خط الانتاج  المحدد'])
->withInput();
}
$row = get_cols_where_row_orderby(new Inv_production_exchange(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC');
if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['order_date'] = $request->order_date;
$data_insert['order_type'] = 1;
$data_insert['inv_production_order_auto_serial'] = $request->inv_production_order_auto_serial;
$data_insert['production_lines_code'] = $request->production_lines_code;
$data_insert['pill_type'] = $request->pill_type;
$data_insert['store_id'] = $request->store_id;
$data_insert['account_number'] = $Inv_production_line_data['account_number'];
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
insert(new Inv_production_exchange(),$data_insert);
//$id = get_field_value(new Suppliers_with_orders(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => 3));
return redirect()->route("admin.inv_production_exchange.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}


public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$Inv_production_lines = get_cols_where(new Inv_production_lines(), array('production_lines_code', 'name'), array('com_code' => $com_code), 'id', 'ASC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code), 'id', 'DESC');
$Inv_production_order = get_cols_where(new Inv_production_order(), array( 'auto_serial'), array('com_code' => $com_code, 'is_closed' => 0,'is_approved'=>1), 'id', 'DESC');
$added_counter_details=get_count_where(new Inv_production_exchange_details(),array("com_code"=>$com_code,"order_type"=>1,"inv_production_exchange_auto_serial"=>$data['auto_serial']));
return view('admin.inv_production_exchange.edit', ['data' => $data, 'Inv_production_lines' => $Inv_production_lines, 'stores' => $stores,'Inv_production_order'=>$Inv_production_order,'added_counter_details'=>$added_counter_details]);
}
public function update($id, inv_production_exchangeUpRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_exchange(), array("is_approved","auto_serial"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$data_Inv_production_line = get_cols_where_row(new Inv_production_lines(), array("account_number"), array("production_lines_code" => $request->production_lines_code, "com_code" => $com_code));
if (empty($data_Inv_production_line)) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا غير قادر علي الوصول الي  بيانات خط الانتاج !!']);
}
$added_counter_details=get_count_where(new Inv_production_exchange_details(),array("com_code"=>$com_code,"order_type"=>1,"inv_production_exchange_auto_serial"=>$data['auto_serial']));
if($added_counter_details==0){
$data_to_update['store_id'] = $request->store_id;
$data_to_update['production_lines_code'] = $request->production_lines_code;
$data_to_update['account_number'] = $data_Inv_production_line['account_number'];
}
$data_to_update['order_date'] = $request->order_date;
$data_to_update['notes'] = $request->notes;
$data_to_update['inv_production_order_auto_serial'] = $request->inv_production_order_auto_serial;
$data_to_update['pill_type'] = $request->pill_type;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new Inv_production_exchange(), $data_to_update, array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
return redirect()->route('admin.inv_production_exchange.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
$data['production_lines_name'] = Inv_production_lines::where('production_lines_code', $data['production_lines_code'])->value('name');
$data['store_name'] = Store::where('id', $data['store_id'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}

$details = get_cols_where(new Inv_production_exchange_details(), array("*"), array('inv_production_exchange_auto_serial' => $data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}
}
}
return view("admin.inv_production_exchange.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new Inv_production_exchange(), array("is_approved","store_id"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$item_cards = get_cols_where(new Inv_itemCard(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'id' => $parent_pill_data['store_id']), 'id', 'DESC');
return view("admin.inv_production_exchange.load_add_new_itemdetails", ['parent_pill_data' => $parent_pill_data, 'item_cards' => $item_cards,'stores'=>$stores]);
}
}
}
}


public function get_item_uoms(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$item_code = $request->item_code;
$item_card_Data = get_cols_where_row(new Inv_itemCard(), array("does_has_retailunit", "retail_uom_id", "uom_id"), array("item_code" => $item_code, "com_code" => $com_code));
if (!empty($item_card_Data)) {
if ($item_card_Data['does_has_retailunit'] == 1) {
$item_card_Data['parent_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['uom_id']));
$item_card_Data['retial_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['retail_uom_id']));
} else {
$item_card_Data['parent_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['uom_id']));
}
}
return view("admin.suppliers_orders_general_return.get_item_uoms", ['item_card_Data' => $item_card_Data]);
}
}
public function get_item_batches(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$item_card_Data = get_cols_where_row(new Inv_itemCard(), array("item_type", "uom_id", "retail_uom_quntToParent"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($item_card_Data)) {
$requesed['uom_id'] = $request->uom_id;
$requesed['store_id'] = $request->store_id;
$requesed['item_code'] = $request->item_code;
$parent_uom = $item_card_Data['uom_id'];
$uom_Data = get_cols_where_row(new Inv_uom(), array("name", "is_master"), array("com_code" => $com_code, "id" => $requesed['uom_id']));
if (!empty($uom_Data)) {
//لو صنف مخزني يبقي ههتم بالتواريخ
if ($item_card_Data['item_type'] == 2) {
$inv_itemcard_batches = get_cols_where(
new Inv_itemcard_batches(),
array("unit_cost_price", "quantity", "production_date", "expired_date", "auto_serial"),
array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "inv_uoms_id" => $parent_uom),
'production_date',
'ASC'
);
} else {
$inv_itemcard_batches = get_cols_where(
new Inv_itemcard_batches(),
array("unit_cost_price", "quantity", "auto_serial"),
array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "inv_uoms_id" => $parent_uom),
'id',
'ASC'
);
}
return view("admin.suppliers_orders_general_return.get_item_batches", ['item_card_Data' => $item_card_Data, 'requesed' => $requesed, 'uom_Data' => $uom_Data, 'inv_itemcard_batches' => $inv_itemcard_batches]);
}
}
}
}




public function Add_item_to_invoice(Request $request)
{ 
try {
if ($request->ajax()) { 
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Inv_production_exchange(), array("is_approved", "order_date", "production_lines_code","id"), array("com_code" => $com_code, "auto_serial" => $request->autoserailparent,'order_type'=>1));
if (!empty($invoice_data)) {  
if ($invoice_data['is_approved'] == 0) {
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $request->inv_itemcard_batches_autoserial, 'store_id' => $request->store_id, 'item_code' => $request->item_code));
if (!empty($batch_data)) {
if ($batch_data['quantity'] >= $request->item_quantity) {
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($itemCard_Data)) {
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
$datainsert_items['inv_production_exchange_auto_serial'] = $request->autoserailparent;
$datainsert_items['order_type'] = 1;
$datainsert_items['inv_production_exchange_id'] =$invoice_data['id'];
$datainsert_items['order_date'] = $invoice_data['order_date'];
$datainsert_items['item_code'] = $request->item_code;
$datainsert_items['uom_id'] = $request->uom_id;
$datainsert_items['batch_auto_serial'] = $request->inv_itemcard_batches_autoserial;
$datainsert_items['deliverd_quantity'] = $request->item_quantity;
$datainsert_items['unit_price'] = $request->item_price;
$datainsert_items['total_price'] = $request->item_total;
$datainsert_items['isparentuom'] = $request->isparentuom;
$datainsert_items['item_card_type'] = $itemCard_Data['item_type'];
$datainsert_items['production_date'] = $batch_data['production_date'];
$datainsert_items['expire_date'] = $batch_data['expired_date'];
$datainsert_items['added_by'] = auth()->user()->id;
$datainsert_items['created_at'] = date("Y-m-d H:i:s");
$datainsert_items['com_code'] = $com_code;
$flag_datainsert_items = insert(new Inv_production_exchange_details(), $datainsert_items, true);
if (!empty($flag_datainsert_items)) {
$this->recalclate_parent_invoice($request->autoserailparent);
//خصم الكمية من الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $request->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $request->item_code, "com_code" => $com_code,
'store_id' => $request->store_id
)
);
//هنا حخصم الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($request->isparentuom==1){
//حخصم بشكل مباشر لانه بنفس وحده الباتش الاب
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] - $request->item_quantity;
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل الخصم انتبه !!
$item_quantityByParentUom=$request->item_quantity/$itemCard_Data['retail_uom_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] - $item_quantityByParentUom;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $request->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array("item_code" => $request->item_code, "com_code" => $com_code, 'store_id' => $request->store_id)
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 4;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 17;
$dataInsert_inv_itemcard_movements['item_code'] = $request->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $request->autoserailparent;
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $flag_datainsert_items['id'];
$production_lines_name = Inv_production_lines::where('production_lines_code', $invoice_data['production_lines_code'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = " نظير ًرف خامات   الي خط انتاج " . " " . $production_lines_name . " فاتورة رقم" . " " . $request->autoserailparent;
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $request->store_id;
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new Inv_itemCard(),
$request->item_code,
new Inv_itemcard_batches(),
$itemCard_Data['does_has_retailunit'],
$itemCard_Data['retail_uom_quntToParent']
);
echo  json_encode("done");
}
}
}
}
}
}
}
}
}
} catch (\Exception $ex) {
echo "there is error " . $ex->getMessage();
}
}



function recalclate_parent_invoice($auto_serial)
{
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("com_code" => $com_code, "auto_serial" => $auto_serial,'order_type'=>1));
if (!empty($invoice_data)) {
//first get sum of details
$dataUpdateParent['total_cost_items'] =get_sum_where(new Inv_production_exchange_details(),"total_price",array("com_code" => $com_code, "inv_production_exchange_auto_serial" => $auto_serial,'order_type'=>1));
$dataUpdateParent['total_cost'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['total_befor_discount'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['money_for_account'] =$dataUpdateParent['total_cost_items'];
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
update(new Inv_production_exchange(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $auto_serial,'order_type'=>1));
}
}


public function reload_parent_pill(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
if (!empty($data)) {
    $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
    $data['production_lines_name'] = Inv_production_lines::where('production_lines_code', $data['production_lines_code'])->value('name');
    $data['store_name'] = Store::where('id', $data['store_id'])->value('name');
    if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
    }
return view("admin.inv_production_exchange.reload_parent_pill", ['data' => $data]);
}
}
}

public function reload_itemsdetials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$auto_serial = $request->autoserailparent;
$data = get_cols_where_row(new Inv_production_exchange(), array("is_approved","id"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));

  $details = get_cols_where(new Inv_production_exchange_details(), array("*"), array('inv_production_exchange_auto_serial' => $auto_serial, 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
    if (!empty($details)) {
    foreach ($details as $info) {
    $info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
    $info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
    $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
    if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
    }
    }
    }

return view("admin.inv_production_exchange.reload_itemsdetials", ['data' => $data, 'details' => $details]);
}
}



public function delete_details($id, $parent_id)
{ 
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new Inv_production_exchange(), array("is_approved", "auto_serial","store_id","production_lines_code"), array("id" => $parent_id, "com_code" => $com_code, 'order_type' => 1));
if (empty($parent_pill_data)) {
return redirect()->back()
->with(['error' => ' عفوا حدث خطأ ما'  ]);
}
if ($parent_pill_data['is_approved'] == 1) {
if (empty($parent_pill_data)) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف بتفاصيل فاتورة معتمده ومؤرشفة']);
}
}
$item_row = Inv_production_exchange_details::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
/** update parent pill */
$this->recalclate_parent_invoice($parent_pill_data['auto_serial']);
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $item_row['item_code']));
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $item_row['batch_auto_serial'], 'store_id' => $parent_pill_data['store_id'], 'item_code' => $item_row['item_code']));
if (!empty($itemCard_Data) and !empty($batch_data)) {
//خصم الكمية من الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'], "com_code" => $com_code,
'store_id' => $parent_pill_data['store_id']
)
);
//حنرجع  الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($item_row['isparentuom']==1){
//حنرجع بشكل مباشر لانه بنفس وحده الباتش الاب
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_row['deliverd_quantity'];
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل الخصم انتبه !!
$item_quantityByParentUom=$item_row['deliverd_quantity']/$itemCard_Data['retail_uom_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByParentUom;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $item_row['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array("item_code" => $item_row['item_code'], "com_code" => $com_code, 'store_id' => $parent_pill_data['store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 4;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 18;
$dataInsert_inv_itemcard_movements['item_code'] = $item_row['item_code'];
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $parent_pill_data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $item_row['id'];
$production_lines_name = Inv_production_lines::where('production_lines_code', $parent_pill_data['production_lines_code'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = " نظير حذف سطر الصنف من فاتورة صرف خامات  لخط الانتاج     " . " " . $production_lines_name . " فاتورة رقم" . " " . $parent_pill_data['auto_serial'];
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $parent_pill_data['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new Inv_itemCard(),
$item_row['item_code'],
new Inv_itemcard_batches(),
$itemCard_Data['does_has_retailunit'],
$itemCard_Data['retail_uom_quntToParent']
);
return redirect()->back()
->with(['success' => '   تم حذف البيانات بنجاح']);
}
}else{
return redirect()->back()
->with(['error' => '2عفوا حدث خطأ ما']);
}
}else{
return redirect()->back()
->with(['error' => '3عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => '4عفوا حدث خطأ ما']);
}
} else {
return redirect()->back()
->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => '5عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}




public function delete($id)
{
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new Inv_production_exchange(), array("is_approved", "auto_serial","store_id","production_lines_code"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
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
//حنجيب الاصناف المضافة علي الفاتورة
$items_details=get_cols_where(new Inv_production_exchange_details(),array("*"),array("com_code"=>$com_code,"order_type"=>1,"inv_production_exchange_auto_serial"=>$parent_pill_data['auto_serial']));
//حنحذف الفاتورة الاب
$flag = delete(new Inv_production_exchange(), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if ($flag) {
//حنلف علي الاصناف المضافه علي الفاتورة ونطبق عليهم نفس اللي عملناها في حذف تفاصيل عنصر علي الفاتورة
if(!empty($items_details)){
foreach($items_details as $info){
      //حيتم الحذف بشكل الي من خلال العلاقه بين الجدولين ونقدر نستغني عن الكود الخاص بالحذف  
$flagDelete=delete(new Inv_production_exchange_details(),array("com_code"=>$com_code,"order_type"=>1,"inv_production_exchange_auto_serial"=>$parent_pill_data['auto_serial'],'id'=>$info->id));
if($flagDelete){


$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $info->item_code));
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $info->batch_auto_serial, 'store_id' => $parent_pill_data['store_id'], 'item_code' => $info->item_code));
if (!empty($itemCard_Data) and !empty($batch_data)) {
//رد الي الكمية الي الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $info->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $info->item_code, "com_code" => $com_code,
'store_id' => $parent_pill_data['store_id']
)
);
//هنا حنرجع الكمية لحظيا من باتش الصنف
//update current Batch تحديث علي الباتش القديمة
if($info->isparentuom==1){
//حخصم بشكل مباشر لانه بنفس وحده الباتش الاب
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $info->deliverd_quantity;
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل الخصم انتبه !!
$item_quantityByParentUom=$info->deliverd_quantity/$itemCard_Data['retail_uom_quntToParent'];
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByParentUom;
}
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $info->item_code,
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $parent_pill_data['store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 4;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 18;
$dataInsert_inv_itemcard_movements['item_code'] = $info->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $parent_pill_data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $info->id;
$production_lines_name = Inv_production_lines::where('production_lines_code', $parent_pill_data['production_lines_code'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = " نظير حذف سطر الصنف من فاتورة صرف خامات  لخط الانتاج     " . " " . $production_lines_name . " فاتورة رقم" . " " . $parent_pill_data['auto_serial'];
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $parent_pill_data['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new Inv_itemCard(),
$info->item_code,
new Inv_itemcard_batches(),
$itemCard_Data['does_has_retailunit'],
$itemCard_Data['retail_uom_quntToParent']
);
}
}
}
}
}
}
return redirect()->route('admin.inv_production_exchange.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function load_modal_approve_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
//current user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
$counterDetails=get_count_where(new Inv_production_exchange_details(),array("inv_production_exchange_auto_serial"=>$request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
return view("admin.inv_production_exchange.load_modal_approve_invoice", ['data' => $data, 'user_shift' => $user_shift,'counterDetails'=>$counterDetails]);
}
}
public function load_usershiftDiv(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
//current user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
}
return view("admin.inv_production_exchange.load_usershiftDiv", ['user_shift' => $user_shift]);
}
//اعتماد وترحيل فاتورة صرف خامات لخط الانتاج 
function do_approve($auto_serial, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
$data = get_cols_where_row(new Inv_production_exchange(), array("total_cost_items", "is_approved", "id", "account_number", "store_id", "production_lines_code"), array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route("admin.inv_production_exchange.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($data['is_approved'] == 1) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => "عفوا لايمكن اعتماد فاتورة معتمده من قبل !!"]);
}
$production_lines_name = Inv_production_lines::where('production_lines_code', $data['production_lines_code'])->value('name');
$counterDetails=get_count_where(new Inv_production_exchange_details(),array("inv_production_exchange_auto_serial"=>$auto_serial, "com_code" => $com_code, 'order_type' => 1));
if ($counterDetails== 0) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => "عفوا لايمكن اعتماد الفاتورة قبل اضافة الأصناف عليها !!!            "]);
}
$dataUpdateParent['tax_percent'] = $request['tax_percent'];
$dataUpdateParent['tax_value'] = $request['tax_value'];
$dataUpdateParent['total_befor_discount'] = $request['total_befor_discount'];
$dataUpdateParent['discount_type'] = $request['discount_type'];
$dataUpdateParent['discount_percent'] = $request['discount_percent'];
$dataUpdateParent['discount_value'] = $request['discount_value'];
$dataUpdateParent['total_cost'] = $request['total_cost'];
$dataUpdateParent['pill_type'] = $request['pill_type'];
$dataUpdateParent['money_for_account'] = $request['total_cost'] ;
$dataUpdateParent['is_approved'] = 1;
$dataUpdateParent['approved_by'] = auth()->user()->com_code;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
//first check for pill type sate cash
if ($request['pill_type'] == 1) {
if ($request['what_paid'] != $request['total_cost']) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => "عفوا يجب ان يكون المبلغ بالكامل مدفوع في حالة الفاتورة كاش !!"]);
}
}
//second  check for pill type sate agel
if ($request['pill_type'] == 2) {
if ($request['what_paid'] == $request['total_cost']) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => "عفوا يجب ان لايكون المبلغ بالكامل مدفوع في حالة الفاتورة اجل !!"]);
}
}
$dataUpdateParent['what_paid'] = $request['what_paid'];
$dataUpdateParent['what_remain'] = $request['what_remain'];
//thaird  check for what paid 
if ($request['what_paid'] > 0) {
if ($request['what_paid'] > $request['total_cost']) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => "عفوا يجب ان لايكون المبلغ المدفوع اكبر من اجمالي الفاتورة      !!"]);
}
//check for user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
//chehck if is empty
if (empty($user_shift)) {
return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['error' => " عفوا لاتملتك الان شفت خزنة مفتوح لكي تتمكن من اتمام عمليه الصرف"]);
}
}
$flag = update(new Inv_production_exchange(), $dataUpdateParent, array("auto_serial" => $auto_serial, "com_code" => $com_code, 'order_type' => 1));
if ($flag) {
//سيتم التحديث هنا عند استكمال دوره خط الانتاج
//Affect on Supplier Balance  حنأثر في رصيد خط الانتاج
//حنجيب  سجل المورد من الشجره المحاسبية برقم الحساب المالب
//حركات  مختلفه
//first make treasuries_transactions  action if what paid >0

if ($request['what_paid'] > 0) {
//first get isal number with treasuries 
$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_collect"), array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
if (empty($treasury_date)) {
return redirect()->route("admin.suppliers_orders.show", $data['id'])->with(['error' => " عفوا غير قادر علي الوصول الي بيانات الخزنة المطلوبة"]);
}
$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert_treasuries_transactions['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert_treasuries_transactions['auto_serial'] = 1;
}
$dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_collect'] + 1;
$dataInsert_treasuries_transactions['shift_code'] = $user_shift['shift_code'];
// مدين
$dataInsert_treasuries_transactions['money'] = $request['what_paid'];
$dataInsert_treasuries_transactions['treasuries_id'] = $user_shift['treasuries_id'];
$dataInsert_treasuries_transactions['mov_type'] = 10;
$dataInsert_treasuries_transactions['move_date'] = date("Y-m-d");
$dataInsert_treasuries_transactions['account_number'] = $data["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
$dataInsert_treasuries_transactions['is_approved'] = 1;
$dataInsert_treasuries_transactions['the_foregin_key'] = $data["auto_serial"];
//debit مدين
$dataInsert_treasuries_transactions['money_for_account'] = $request['what_paid']*(-1);
$dataInsert_treasuries_transactions['byan'] = "تحصيل نظير فاتورة مرتجع مشتريات عام فاتورة  رقم" . $auto_serial;
$dataInsert_treasuries_transactions['created_at'] = date("Y-m-Y H:i:s");
$dataInsert_treasuries_transactions['added_by'] = auth()->user()->id;
$dataInsert_treasuries_transactions['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert_treasuries_transactions);
if ($flag) {
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_collect'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
}
}

refresh_account_blance_ProductionLine($data['account_number'], new Account(), new Inv_production_lines(), new Treasuries_transactions(),new services_with_orders(),new Inv_production_exchange(),new inv_production_receive(), false);


return redirect()->route("admin.inv_production_exchange.show", $data['id'])->with(['success' => " تم اعتماد وترحيل الفاتورة بنجاح  "]);
}
}


public function ajax_search(Request $request)
{
if ($request->ajax()) {
$search_by_text = $request->search_by_text;
$production_lines_code = $request->production_lines_code;
$store_id = $request->store_id;
$order_date_form = $request->order_date_form;
$order_date_to = $request->order_date_to;
$searchbyradio = $request->searchbyradio;
$is_approved = $request->is_approved;

if ($production_lines_code == 'all') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "production_lines_code";
$operator1 = "=";
$value1 = $production_lines_code;
}
if ($store_id == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "store_id";
$operator2 = "=";
$value2 = $store_id;
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
} else {
$field5 = "inv_production_order_auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
}
} else {
//true 
$field5 = "id";
$operator5 = ">";
$value5 = 0;
}

if ($is_approved == 'all') {
  //دائما  true
  $field6 = "id";
  $operator6 = ">";
  $value6 = 0;
  } else {
  $field6 = "is_approved";
  $operator6 = "=";
  $value6 = $is_approved;
  }

$data = Inv_production_exchange::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where($field6, $operator6, $value6)->where('order_type','=',1)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
  foreach ($data as $info) {
  $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
  $info->production_lines_name = Inv_production_lines::where('production_lines_code', $info->production_lines_code)->value('name');
  $info->store_name = Store::where('id', $info->store_id)->value('name');
  if ($info->updated_by > 0 and $info->updated_by != null) {
  $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
  }
  }
  }
return view('admin.inv_production_exchange.ajax_search', ['data' => $data]);
}
}

public function printsaleswina4($id,$size){

  try {
  $com_code = auth()->user()->com_code;
  $invoice_data = get_cols_where_row(new Inv_production_exchange(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
  if (empty($invoice_data)) {
  return redirect()->route('admin.inv_production_exchange.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
  }
  $invoice_data['added_by_admin'] = Admin::where('id', $invoice_data['added_by'])->value('name');
  $invoice_data['production_lines_name'] = Inv_production_lines::where('production_lines_code', $invoice_data['production_lines_code'])->value('name');
  $invoice_data['production_lines_phones'] = Inv_production_lines::where('production_lines_code', $invoice_data['production_lines_code'])->value('phones');
  $invoice_data['store_name'] = Store::where('id', $invoice_data['store_id'])->value('name');  
$invoices_details = get_cols_where(new Inv_production_exchange_details(), array("*"), array('inv_production_exchange_auto_serial' => $invoice_data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code), 'id', 'ASC');
  if (!empty($invoices_details)) {
  foreach ($invoices_details as $info) {
  $info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
  $info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
  }
  }
  $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
  
  if($size=="A4"){
      return view('admin.inv_production_exchange.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
  }else{
      return view('admin.inv_production_exchange.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
  
  }
  } catch (\Exception $ex) {
  return redirect()->back()
  ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
  }
  }
  
}