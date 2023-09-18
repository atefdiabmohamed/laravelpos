<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use App\Models\inv_stores_transfer;
use App\Models\inv_stores_transfer_details;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Store;
use App\Models\Inv_itemcard_movements;
use App\Models\Admin_panel_setting;
use App\Models\Inv_itemcard_batches;
use App\Http\Requests\Inv_stores_transferRequest;
use App\Http\Requests\Inv_stores_transferRequestUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class Inv_stores_transferController extends Controller
{
public function index()
{ 
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new inv_stores_transfer(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->from_store_name = Store::where('id', $info->transfer_from_store_id)->value('name');
$info->to_store_name = Store::where('id', $info->transfer_to_store_id)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'ASC');
return view('admin.inv_stores_transfer.index', ['data' => $data, 'stores' => $stores]);
}
public function create(){
$com_code = auth()->user()->com_code;
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'ASC');
return view('admin.inv_stores_transfer.create', ['stores' => $stores]);
}
public function store(Inv_stores_transferRequest $request)
{
try {
$com_code = auth()->user()->com_code;
if($request->transfer_from_store_id==$request->transfer_to_store_id){
return redirect()->back()
->with(['error' => 'عفوا  لايمكن ان يكون مخزن الصرف هو نفسه مخزن الاستلام  !!'])
->withInput();  
}
$CheckOpenOrder = get_cols_where_row(new inv_stores_transfer(), array("auto_serial"), array("com_code" => $com_code,'transfer_from_store_id'=>$request->transfer_from_store_id,"transfer_to_store_id"=>$request->transfer_to_store_id,'is_approved'=>0));
if (!empty($CheckOpenOrder)) { 
return redirect()->back()
->with(['error' => 'عفوا هناك بالفعل أمر تحويل مازال مفتوح بين المخزنين   !!'])
->withInput();   
}
$row = get_cols_where_row_orderby(new inv_stores_transfer(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['order_date'] = $request->order_date;
$data_insert['transfer_from_store_id'] = $request->transfer_from_store_id;
$data_insert['transfer_to_store_id'] = $request->transfer_to_store_id;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
insert(new inv_stores_transfer(),$data_insert);
return redirect()->route("admin.inv_stores_transfer.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
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
$data = get_cols_where_row(new inv_stores_transfer(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
$data['from_store_name'] = Store::where('id', $data['transfer_from_store_id'])->value('name');
$data['to_store_name'] = Store::where('id', $data['transfer_to_store_id'])->value('name');$data['store_name'] = Store::where('id', $data['store_id'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}
$data['notgiveStatecounter_details']=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$data['auto_serial'],'is_approved'=>0,'is_canceld_receive'=>0));

$details = get_cols_where(new inv_stores_transfer_details(), array("*"), array('inv_stores_transfer_auto_serial' => $data['auto_serial'],  'com_code' => $com_code), 'id', 'DESC');
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
return view("admin.inv_stores_transfer.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_stores_transfer(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code), 'id', 'DESC');
$added_counter_details=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$data['auto_serial']));
return view('admin.inv_stores_transfer.edit', ['data' => $data, 'stores' => $stores,'added_counter_details'=>$added_counter_details]);
}
public function update($id, Inv_stores_transferRequestUpdate $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_stores_transfer(), array("is_approved","auto_serial"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$added_counter_details=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$data['auto_serial']));
if($added_counter_details==0){
$data_to_update['transfer_from_store_id'] = $request->transfer_from_store_id ;
$data_to_update['transfer_to_store_id'] = $request->transfer_to_store_id;
}
$data_to_update['order_date'] = $request->order_date;
$data_to_update['notes'] = $request->notes;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new inv_stores_transfer(), $data_to_update, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.inv_stores_transfer.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$parent_pill_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved", "auto_serial"), array("id" => $id, "com_code" => $com_code));
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
$added_counter_details=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$parent_pill_data['auto_serial']));
if($added_counter_details>0){
return redirect()->back()
->with(['error' => 'عفوا  لايمكن الحذف لوجوده اصناف بالفعل مضافة علي أمر التحويل!   ']);   
}
//حنحذف الفاتورة الاب
$flag = delete(new inv_stores_transfer(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
delete(new inv_stores_transfer_details(), array("inv_stores_transfer_auto_serial" => $parent_pill_data['auto_serail'], "com_code" => $com_code));
}
return redirect()->route('admin.inv_stores_transfer.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved","transfer_from_store_id"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$item_cards = get_cols_where(new Inv_itemCard(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'id' => $parent_pill_data['transfer_from_store_id']), 'id', 'DESC');
return view("admin.inv_stores_transfer.load_add_new_itemdetails", ['parent_pill_data' => $parent_pill_data, 'item_cards' => $item_cards,'stores'=>$stores]);
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
return view("admin.inv_stores_transfer.get_item_uoms", ['item_card_Data' => $item_card_Data]);
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
return view("admin.inv_stores_transfer.get_item_batches", ['item_card_Data' => $item_card_Data, 'requesed' => $requesed, 'uom_Data' => $uom_Data, 'inv_itemcard_batches' => $inv_itemcard_batches]);
}
}
}
}
public function Add_item_to_invoice(Request $request)
{ 
try {
if ($request->ajax()) { 
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved", "order_date","id","transfer_from_store_id","transfer_to_store_id"), array("com_code" => $com_code, "auto_serial" => $request->autoserailparent));
if (!empty($invoice_data)) {  
if ($invoice_data['is_approved'] == 0) {
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $request->inv_itemcard_batches_autoserial, 'store_id' => $request->store_id, 'item_code' => $request->item_code));
if (!empty($batch_data)) {
if ($batch_data['quantity'] >= $request->item_quantity) {
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($itemCard_Data)) {
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
$datainsert_items['inv_stores_transfer_auto_serial'] = $request->autoserailparent;
$datainsert_items['inv_stores_transfer_id']=$invoice_data['id'];
$datainsert_items['order_date'] = $invoice_data['order_date'];
$datainsert_items['item_code'] = $request->item_code;
$datainsert_items['uom_id'] = $request->uom_id;
$datainsert_items['transfer_from_batch_id'] = $request->inv_itemcard_batches_autoserial;
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
$flag_datainsert_items = insert(new inv_stores_transfer_details(), $datainsert_items, true);
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
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 3;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 20;
$dataInsert_inv_itemcard_movements['item_code'] = $request->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $request->autoserailparent;
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $flag_datainsert_items['id'];
$to_store_name = Store::where('id', $invoice_data['transfer_to_store_id'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = " نظير صرف أصناف  الي مخزن الاستلام " . " " . $to_store_name . " أمر تحويل رقم" . " " . $request->autoserailparent;
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
$invoice_data = get_cols_where_row(new inv_stores_transfer(), array("auto_serial"), array("com_code" => $com_code, "auto_serial" => $auto_serial));
if (!empty($invoice_data)) {
//first get sum of details
$dataUpdateParent['total_cost_items'] =get_sum_where(new inv_stores_transfer_details(),"total_price",array("com_code" => $com_code, "inv_stores_transfer_auto_serial" => $auto_serial));
$dataUpdateParent['items_counter'] =get_sum_where(new inv_stores_transfer_details(),"deliverd_quantity",array("com_code" => $com_code, "inv_stores_transfer_auto_serial" => $auto_serial));
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
update(new inv_stores_transfer(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $auto_serial));
}
}
public function reload_parent_pill(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_stores_transfer(), array("*"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code));
if (!empty($data)) {
    $data['notgiveStatecounter_details']=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$data['auto_serial'],'is_approved'=>0,'is_canceld_receive'=>0));
    $data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
$data['from_store_name'] = Store::where('id', $data['transfer_from_store_id'])->value('name');
$data['to_store_name'] = Store::where('id', $data['transfer_to_store_id'])->value('name');$data['store_name'] = Store::where('id', $data['store_id'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}
return view("admin.inv_stores_transfer.reload_parent_pill", ['data' => $data]);
}
}
}
public function reload_itemsdetials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$auto_serial = $request->autoserailparent;
$data = get_cols_where_row(new inv_stores_transfer(), array("is_approved","id"), array("auto_serial" => $auto_serial, "com_code" => $com_code));
$details = get_cols_where(new inv_stores_transfer_details(), array("*"), array('inv_stores_transfer_auto_serial' => $auto_serial, 'com_code' => $com_code), 'id', 'DESC');
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
return view("admin.inv_stores_transfer.reload_itemsdetials", ['data' => $data, 'details' => $details]);
}
}


public function delete_details($id, $parent_id)
{ 
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved", "auto_serial","transfer_from_store_id","transfer_to_store_id"), array("id" => $parent_id, "com_code" => $com_code));
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
$item_row = inv_stores_transfer_details::find($id);
if (!empty($item_row)) {
$flag = $item_row->delete();
if ($flag) {
/** update parent pill */
$this->recalclate_parent_invoice($parent_pill_data['auto_serial']);
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit","item_type"), array("com_code" => $com_code, "item_code" => $item_row['item_code']));
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id","production_date","expired_date"), array("com_code" => $com_code, "auto_serial" => $item_row['transfer_from_batch_id'], 'store_id' => $parent_pill_data['transfer_from_store_id'], 'item_code' => $item_row['item_code']));
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
'store_id' => $parent_pill_data['transfer_from_store_id']
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
array("item_code" => $item_row['item_code'], "com_code" => $com_code, 'store_id' => $parent_pill_data['transfer_from_store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 3;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 21;
$dataInsert_inv_itemcard_movements['item_code'] = $item_row['item_code'];
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $parent_pill_data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $item_row['id'];
$to_store_name = Store::where('id', $parent_pill_data['transfer_to_store_id'])->value('name');
$from_store_name = Store::where('id', $parent_pill_data['transfer_from_store_id'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = " نظير حذف سطر الصنف من أمر تحويل من المخزن            " . " " . $from_store_name."  الي المخزن" .$to_store_name. " امر تحويل" . " " . $parent_pill_data['auto_serial'];
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $parent_pill_data['transfer_from_store_id'];
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
public function do_approve($id)
{
try {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved", "auto_serial"), array("id" => $id, "com_code" => $com_code));
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
$added_counter_details=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$parent_pill_data['auto_serial']));
if($added_counter_details==0){
return redirect()->back()
->with(['error' => 'عفوا لايمكن اغلاق وارشفة الامر قبل اضافة الاصناف عليه!   ']);   
}
$notgiveStatecounter_details=get_count_where(new inv_stores_transfer_details(),array("com_code"=>$com_code,"inv_stores_transfer_auto_serial"=>$parent_pill_data['auto_serial'],'is_approved'=>0,'is_canceld_receive'=>0));
if($notgiveStatecounter_details>0){
    return redirect()->back()
    ->with(['error' => 'عفوا هناك اصناف مازالت لم تأخذ اي حركة اعتماد او الغاء الاستلام !!  ']);   
    }

$DataToUpdate['is_approved']=1;
$DataToUpdate["approved_at"] = date("Y-m-d H:i:s");
$DataToUpdate["approved_by"] = auth()->user()->id;
$flag = update(new inv_stores_transfer(),$DataToUpdate, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.inv_stores_transfer.index')->with(['success' => 'لقد تم اغلاق وأرشفة الامر بنجاح  البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function ajax_search(Request $request)
{
if ($request->ajax()) {
$search_by_text = $request->search_by_text;
$transfer_from_store_id_search = $request->transfer_from_store_id_search;
$transfer_to_store_id_search = $request->transfer_to_store_id_search;
$order_date_form = $request->order_date_form;
$order_date_to = $request->order_date_to;
$searchbyradio = $request->searchbyradio;
$is_approved = $request->is_approved;

if ($transfer_from_store_id_search == 'all') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "transfer_from_store_id";
$operator1 = "=";
$value1 = $transfer_from_store_id_search;
}
if ($transfer_to_store_id_search == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "transfer_to_store_id";
$operator2 = "=";
$value2 = $transfer_to_store_id_search;
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
$field5 = "auto_serial";
$operator5 = "=";
$value5 = $search_by_text;
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

$data = inv_stores_transfer::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where($field6, $operator6, $value6)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    $info->from_store_name = Store::where('id', $info->transfer_from_store_id)->value('name');
    $info->to_store_name = Store::where('id', $info->transfer_to_store_id)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }
return view('admin.inv_stores_transfer.ajax_search', ['data' => $data]);
}
}

public function printsaleswina4($id,$size){

    try {
    $com_code = auth()->user()->com_code;
    $invoice_data = get_cols_where_row(new inv_stores_transfer(), array("*"), array("id" => $id, "com_code" => $com_code));
    if (empty($invoice_data)) {
    return redirect()->route('admin.inv_stores_transfer.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
 $invoice_data['added_by_admin'] = Admin::where('id', $invoice_data['added_by'])->value('name');
$invoice_data['from_store_name'] = Store::where('id', $invoice_data['transfer_from_store_id'])->value('name');
$invoice_data['to_store_name'] = Store::where('id', $invoice_data['transfer_to_store_id'])->value('name');

  $invoices_details = get_cols_where(new inv_stores_transfer_details(), array("*"), array('inv_stores_transfer_auto_serial' => $invoice_data['auto_serial'], 'com_code' => $com_code), 'id', 'ASC');
    if (!empty($invoices_details)) {
    foreach ($invoices_details as $info) {
    $info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
    $info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
    }
    }
    $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
    
    if($size=="A4"){
        return view('admin.inv_stores_transfer.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
    }else{
        return view('admin.inv_stores_transfer.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
    
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
    }
    

}