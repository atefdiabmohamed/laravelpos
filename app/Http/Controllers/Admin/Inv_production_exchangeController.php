<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
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
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
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
$invoice_data = get_cols_where_row(new Inv_production_exchange(), array("is_approved", "order_date", "production_lines_code"), array("com_code" => $com_code, "auto_serial" => $request->autoserailparent,'order_type'=>1));
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


}