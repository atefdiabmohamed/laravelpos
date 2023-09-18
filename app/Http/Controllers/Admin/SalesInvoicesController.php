<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales_invoices;
use App\Models\Admin;
use App\Models\Sales_matrial_types;
use App\Models\Customer;
use App\Models\Inv_itemCard;
use App\Models\Inv_itemcard_batches;
use App\Models\Inv_uom;
use App\Models\Store;
use App\Models\Treasuries_transactions;
use App\Models\Treasuries;
use App\Models\Admins_Shifts;
use App\Models\Delegate;
use App\Models\Sales_invoices_details;
use App\Models\Inv_itemcard_movements;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Suppliers_with_orders;
use App\Models\SalesReturn;
use App\Models\Admin_panel_setting;
use App\Models\services_with_orders;

class SalesInvoicesController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Sales_invoices(), array("*"), array("com_code" => $com_code), "id", "DESC", PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->Sales_matrial_types_name = get_field_value(new Sales_matrial_types(), "name", array("com_code" => $com_code, "id" => $info->sales_matrial_types));
if ($info->is_has_customer == 1) {
$info->customer_name = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $info->customer_code));
} else {
$info->customer_name = "بدون عميل";
}
}
}
$delegates = get_cols_where(new Delegate(), array("delegate_code", "name"), array("com_code" => $com_code, "active" => 1));
$customers = get_cols_where(new Customer(), array("customer_code", "name"), array("com_code" => $com_code, "active" => 1));
$Sales_matrial_types = get_cols_where(new Sales_matrial_types(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
return view("admin.sales_invoices.index", ['data' => $data, 'delegates' => $delegates, 'customers' => $customers, 'Sales_matrial_types' => $Sales_matrial_types]);
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

$adminPanelSettings=get_cols_where_row(new Admin_panel_setting(),array("default_unit"),array("com_code"=>$com_code));

return view("admin.sales_invoices.get_item_uoms", ['item_card_Data' => $item_card_Data,'adminPanelSettings'=>$adminPanelSettings]);
}
}
//مرآة فاتوةر موقته للعميل لاتؤثر علي اي شيء  مجرد عرض سعر 
public function load_modal_addMirror(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$item_cards = get_cols_where(new Inv_itemCard(), array("item_code", "name", "item_type"), array("com_code" => $com_code, "active" => 1));
$stores = get_cols_where(new Store(), array("id", "name"), array("com_code" => $com_code, "active" => 1), 'id', 'ASC');
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
return view("admin.sales_invoices.loadModalAddInvoiceMirror", ['item_cards' => $item_cards, 'stores' => $stores, 'user_shift' => $user_shift]);
}
}
//عرض صفحة اضافة فاتورة مبيعات فعلية ذات الخصم اللحظي للأصناف من المخازن  
public function load_modal_addActiveInvoice(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$delegates = get_cols_where(new Delegate(), array("delegate_code", "name"), array("com_code" => $com_code, "active" => 1));
$Sales_matrial_types = get_cols_where(new Sales_matrial_types(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
return view("admin.sales_invoices.load_modal_addActiveInvoice", [
'delegates' => $delegates, 'Sales_matrial_types' => $Sales_matrial_types
]);
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

return view("admin.sales_invoices.get_item_batches", ['item_card_Data' => $item_card_Data, 'requesed' => $requesed, 'uom_Data' => $uom_Data, 'inv_itemcard_batches' => $inv_itemcard_batches]);
}
}
}
}
public function get_item_unit_price(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$item_card_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "price", "nos_gomla_price", "gomla_price", "price_retail", "nos_gomla_price_retail", "gomla_price_retail", "does_has_retailunit", "retail_uom_id"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($item_card_Data)) {
$uom_id = $request->uom_id;
$sales_item_type = $request->sales_item_type;
$uom_Data = get_cols_where_row(new Inv_uom(), array("is_master"), array("com_code" => $com_code, "id" => $uom_id));
if (!empty($uom_Data)) {
if ($uom_Data['is_master'] == 1) {
if ($item_card_Data['uom_id'] == $uom_id) {
if ($sales_item_type == 1) {
echo json_encode($item_card_Data['price']);
} elseif ($sales_item_type == 2) {
echo json_encode($item_card_Data['nos_gomla_price']);
} else {
echo json_encode($item_card_Data['gomla_price']);
}
}
} else {
if ($item_card_Data['retail_uom_id'] == $uom_id and $item_card_Data['does_has_retailunit'] == 1) {
if ($sales_item_type == 1) {
echo json_encode($item_card_Data['price_retail']);
} elseif ($sales_item_type == 2) {
echo json_encode($item_card_Data['nos_gomla_price_retail']);
} else {
echo json_encode($item_card_Data['gomla_price_retail']);
}
}
}
}
}
}
}
public function get_Add_new_item_row(Request $request)
{
$com_code = auth()->user()->com_code;
if ($request->ajax()) {
$received_data['store_id'] = $request->store_id;
$received_data['sales_item_type'] = $request->sales_item_type;
$received_data['item_code'] = $request->item_code;
$received_data['uom_id'] = $request->uom_id;
$received_data['inv_itemcard_batches_autoserial'] = $request->inv_itemcard_batches_autoserial;
$received_data['item_quantity'] = $request->item_quantity;
$received_data['item_price'] = $request->item_price;
$received_data['is_normal_orOther'] = $request->is_normal_orOther;
$received_data['item_total'] = $request->item_total;
$received_data['store_name'] = $request->store_name;
$received_data['uom_id_name'] = $request->uom_id_name;
$received_data['item_code_name'] = $request->item_code_name;
$received_data['sales_item_type_name'] = $request->sales_item_type_name;
$received_data['is_normal_orOther_name'] = $request->is_normal_orOther_name;
$received_data['isparentuom'] = $request->isparentuom;
return view('admin.sales_invoices.get_Add_new_item_row', ['received_data' => $received_data]);
}
}
public function store(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
//حنعمل اضافة للفاتورة اول مرة 
$last_auto_serial_Date = get_cols_where_row_orderby(new Sales_invoices(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($last_auto_serial_Date)) {
$data_insert['auto_serial'] = $last_auto_serial_Date['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['invoice_date'] = $request->invoice_date;
$data_insert['is_has_customer'] = $request->is_has_customer;
if ($request->is_has_customer == 1) {
$data_insert['customer_code'] = $request->customer_code;
}
$data_insert['delegate_code'] = $request->delegate_code;
$data_insert['sales_item_type']=$request->sales_item_type_main;
$data_insert['sales_matrial_types'] = $request->sales_matrial_types;
$data_insert['pill_type'] = $request->pill_type;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new Sales_invoices(), $data_insert, false);
if ($flag) {
echo  json_encode($data_insert['auto_serial']);
}
}
}
public function load_invoice_update_modal(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("*"), array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
$stores = get_cols_where(new Store(), array("id", "name"), array("com_code" => $com_code, "active" => 1), 'id', 'ASC');
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
$delegates = get_cols_where(new Delegate(), array("delegate_code", "name"), array("com_code" => $com_code, "active" => 1));
$customers = get_cols_where(new Customer(), array("customer_code", "name"), array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
$Sales_matrial_types = get_cols_where(new Sales_matrial_types(), array("id", "name"), array("com_code" => $com_code, "active" => 1));
$sales_invoices_details = get_cols_where(new Sales_invoices_details(), array("*"), array("com_code" => $com_code, "sales_invoices_auto_serial" => $request->auto_serial));
if (!empty($sales_invoices_details)) {
foreach ($sales_invoices_details  as $info) {
$info->store_name = get_field_value(new Store(), "name", array("com_code" => $com_code, "id" => $info->store_id));
$info->item_name = get_field_value(new Inv_itemCard(), "name", array("com_code" => $com_code, "item_code" => $info->item_code));
$info->uom_name = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $info->uom_id));
}
}
return view("admin.sales_invoices.load_invoice_update_modal", ['stores' => $stores, 'user_shift' =>
$user_shift, 'delegates' => $delegates, 'customers' => $customers, 'Sales_matrial_types' => $Sales_matrial_types, 'invoice_data' => $invoice_data, 'sales_invoices_details' => $sales_invoices_details]);
}
}
public function Add_item_to_invoice(Request $request)
{
try {
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("is_approved", "invoice_date", "is_has_customer", "customer_code","id"), array("com_code" => $com_code, "auto_serial" => $request->invoiceautoserial));
if (!empty($invoice_data)) {
if ($invoice_data['is_approved'] == 0) {
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id"), array("com_code" => $com_code, "auto_serial" => $request->inv_itemcard_batches_autoserial, 'store_id' => $request->store_id, 'item_code' => $request->item_code));
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit"), array("com_code" => $com_code, "item_code" => $request->item_code));
if (!empty($batch_data) and !empty($itemCard_Data)) {
    if($request->isparentuom==1){
        $theQuantity= $request->item_quantity;
    }else{
        $theQuantity=$request->item_quantity/$itemCard_Data['retail_uom_quntToParent'];
    }
   
if ($batch_data['quantity'] >=  $theQuantity) {

$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
$datainsert_items['sales_invoices_auto_serial'] = $request->invoiceautoserial;
$datainsert_items['sales_invoices_id'] = $invoice_data['id'];
$datainsert_items['store_id'] = $request->store_id;
$datainsert_items['invoice_date'] = $invoice_data['invoice_date'];
$datainsert_items['sales_item_type'] = $request->sales_item_type;
$datainsert_items['item_code'] = $request->item_code;
$datainsert_items['uom_id'] = $request->uom_id;
$datainsert_items['batch_auto_serial'] = $request->inv_itemcard_batches_autoserial;
/**  تفاصيل تكلفة الشراء */
if($request->isparentuom==1){
    $datainsert_items['itemCostPriceFromBatch'] = round($batch_data['unit_cost_price'],2);
    $datainsert_items['taoalitemCostPriceFromBatch'] = round($batch_data['unit_cost_price']*$request->item_quantity,2);
    $datainsert_items['item_total_earnings'] = round($request->item_total-($batch_data['unit_cost_price']*$request->item_quantity),2);
}else{
  $unit_cost_price_retail=round(($batch_data['unit_cost_price']/$itemCard_Data['retail_uom_quntToParent']),2);

 $datainsert_items['itemCostPriceFromBatch'] = $unit_cost_price_retail;
  $datainsert_items['taoalitemCostPriceFromBatch'] = round(($unit_cost_price_retail*$request->item_quantity),2);
$datainsert_items['item_total_earnings'] = round(($request->item_total-($unit_cost_price_retail*$request->item_quantity)),2);

}


/**   انتهاء تفاصيل الشراء */

$datainsert_items['quantity'] = $request->item_quantity;
$datainsert_items['unit_price'] = $request->item_price;
$datainsert_items['is_normal_orOther'] = $request->is_normal_orOther;
$datainsert_items['total_price'] = $request->item_total;
$datainsert_items['isparentuom'] = $request->isparentuom;
$datainsert_items['added_by'] = auth()->user()->id;
$datainsert_items['created_at'] = date("Y-m-d H:i:s");
$datainsert_items['date'] = date("Y-m-d");
$datainsert_items['com_code'] = $com_code;
$flag_datainsert_items = insert(new Sales_invoices_details(), $datainsert_items, true);
if (!empty($flag_datainsert_items)) { 
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
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 2;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 4;
$dataInsert_inv_itemcard_movements['item_code'] = $request->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $request->invoiceautoserial;
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $flag_datainsert_items['id'];
if ($invoice_data['is_has_customer'] == 1) {
$customerName = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
} else {
$customerName = " طياري لايوجد";
}
$dataInsert_inv_itemcard_movements['byan'] = "نظير مبيعات  للعميل " . " " . $customerName . " فاتورة رقم" . " " . $request->invoiceautoserial;
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
} catch (\Exception $ex) {
echo "there is error " . $ex->getMessage();
}
}
function reload_items_in_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$sales_invoices_details = get_cols_where(new Sales_invoices_details(), array("*"), array("com_code" => $com_code, "sales_invoices_auto_serial" => $request->auto_serial));
if (!empty($sales_invoices_details)) {
foreach ($sales_invoices_details  as $info) {
$info->store_name = get_field_value(new Store(), "name", array("com_code" => $com_code, "id" => $info->store_id));
$info->item_name = get_field_value(new Inv_itemCard(), "name", array("com_code" => $com_code, "item_code" => $info->item_code));
$info->uom_name = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $info->uom_id));
}
}
return view("admin.sales_invoices.reload_items_in_invoice", ['sales_invoices_details' => $sales_invoices_details]);
}
}
function recalclate_parent_invoice(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("*"), array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
if (!empty($invoice_data)) {
if ($invoice_data['is_approved'] == 0) {
$dataUpdateParent['invoice_date'] = $request->invoice_date;
$dataUpdateParent['is_has_customer'] = $request->is_has_customer;
if ($dataUpdateParent['is_has_customer'] != "") {
$dataUpdateParent['customer_code'] = $request->customer_code;
} else {
$dataUpdateParent['customer_code'] = null;
}
$dataUpdateParent['delegate_code'] = $request->delegate_code;
$dataUpdateParent['sales_item_type'] = $request->sales_item_type;
$dataUpdateParent['pill_type'] = $request->pill_type;
$dataUpdateParent['Sales_matrial_types'] = $request->Sales_matrial_types_id;
$dataUpdateParent['total_cost_items'] = $request->total_cost_items;
$dataUpdateParent['tax_percent'] = $request->tax_percent;
$dataUpdateParent['tax_value'] = $request->tax_value;
$dataUpdateParent['total_befor_discount'] = $request->total_befor_discount;
$dataUpdateParent['discount_type'] = $request->discount_type;
$dataUpdateParent['discount_percent'] = $request->discount_percent;
$dataUpdateParent['discount_value'] = $request->discount_value;
$dataUpdateParent['total_cost'] = $request->total_cost;
$dataUpdateParent['notes'] = $request->notes;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
update(new Sales_invoices(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
echo json_encode("done");
}
}
}
}
function remove_active_row_item(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("is_approved", "is_has_customer", "customer_code"), array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
if (!empty($invoice_data)) {
if ($invoice_data['is_approved'] == 0) {

$sales_invoices_details_data = get_cols_where_row(new Sales_invoices_details(), array("batch_auto_serial", "quantity", "item_code", "store_id","isparentuom"), array("com_code" => $com_code, "id" => $request->id));
if (!empty($sales_invoices_details_data)) {
$batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id"), array("com_code" => $com_code, "auto_serial" => $sales_invoices_details_data['batch_auto_serial']));
if (!empty($batch_data)) {
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit"), array("com_code" => $com_code, "item_code" => $sales_invoices_details_data['item_code']));
if (!empty($itemCard_Data)) {
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
//حذف السطر من تفاصيل الفاتورة
$flag = delete(new Sales_invoices_details(), array("com_code" => $com_code, "id" => $request->id));
if ($flag) {
//رد الكمية الي الباتش 
//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $sales_invoices_details_data['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $sales_invoices_details_data['item_code'], "com_code" => $com_code,
'store_id' => $sales_invoices_details_data['store_id']
)
);
if($sales_invoices_details_data['isparentuom']==1){
//حنرد بشكل مباشر لانه بنفس وحده الباتش الاب
$item_quantityByParentUom =$sales_invoices_details_data['quantity'];
}else{
//مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل ردها للمخزن انتبه !!
$item_quantityByParentUom=$sales_invoices_details_data['quantity']/$itemCard_Data['retail_uom_quntToParent'];
}
//هنا هنرد الكمية لحظيا الي باتش الصنف
//update current Batch تحديث علي الباتش القديمة
$dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByParentUom;
$dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$flag = update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
if ($flag) {
$quantityAfterMove = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array(
"item_code" => $sales_invoices_details_data['item_code'],
"com_code" => $com_code
)
);
//get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
new Inv_itemcard_batches(),
"quantity",
array("item_code" => $sales_invoices_details_data['item_code'], "com_code" => $com_code, 'store_id' => $sales_invoices_details_data['store_id'])
);
//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 2;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 15;
$dataInsert_inv_itemcard_movements['item_code'] = $sales_invoices_details_data['item_code'];
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $request->auto_serial;
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $request->id;
if ($invoice_data['is_has_customer'] == 1) {
$customerName = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
} else {
$customerName = " طياري لايوجد";
}
$dataInsert_inv_itemcard_movements['byan'] = "حذف الصنف من تفاصيل  فاتورة مبيعات  للعميل " . " " . $customerName . " فاتورة رقم" . " " . $request->invoiceautoserial;
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $sales_invoices_details_data['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new Inv_itemCard(),
$sales_invoices_details_data['item_code'],
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
}
public function load_usershiftDiv(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
//current user shift
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
}
return view("admin.sales_invoices.load_usershiftDiv", ['user_shift' => $user_shift]);
}
function DoApproveInvoiceFinally(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("is_approved", "pill_type", "total_cost", "customer_code", "is_has_customer","delegate_code","sales_item_type"), array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
if (!empty($invoice_data)) {
if ($invoice_data['is_approved'] == 0) {
$dataUpdateParent['money_for_account'] = $invoice_data['total_cost'];
$dataUpdateParent['is_approved'] = 1;
$dataUpdateParent['approved_by'] = auth()->user()->com_code;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
$dataUpdateParent['updated_by'] = auth()->user()->com_code;
$dataUpdateParent['what_paid'] = $request->what_paid;
$dataUpdateParent['what_remain'] = $request->what_remain;
if ($invoice_data['is_has_customer'] == 1) {
$customerData = get_cols_where_row(new Customer(), array("account_number"), array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
$dataUpdateParent['account_number'] = $customerData['account_number'];
}
if($invoice_data['delegate_code']>0 and $invoice_data['delegate_code']!=null){
$delegateData = get_cols_where_row(new Delegate(), array("percent_type","percent_salaes_commission_kataei","percent_salaes_commission_nosjomla","percent_salaes_commission_jomla"), array("com_code" => $com_code, "delegate_code" => $invoice_data['delegate_code']));
if(!empty($delegateData)){
if($invoice_data['sales_item_type']==1){
$dataUpdateParent['delegate_commission_percent_type']=$delegateData['percent_type'];
$dataUpdateParent['delegate_commission_percent']=$delegateData['percent_salaes_commission_kataei'];
if($delegateData['percent_type']==1){
$dataUpdateParent['delegate_commission_value']=$delegateData['percent_salaes_commission_kataei']*(-1);
}else{
$dataUpdateParent['delegate_commission_value']=(($invoice_data['total_cost']*$delegateData['percent_salaes_commission_kataei'])/100)*(-1);
}
}elseif($invoice_data['sales_item_type']==2){
$dataUpdateParent['delegate_commission_percent_type']=$delegateData['percent_type'];
$dataUpdateParent['delegate_commission_percent']=$delegateData['percent_salaes_commission_nosjomla'];
if($delegateData['percent_type']==1){
$dataUpdateParent['delegate_commission_value']=$delegateData['percent_salaes_commission_nosjomla']*(-1);;
}else{
$dataUpdateParent['delegate_commission_value']=(($invoice_data['total_cost']*$delegateData['percent_salaes_commission_nosjomla'])/100)*(-1);
}
}else{
$dataUpdateParent['delegate_commission_percent_type']=$delegateData['percent_type'];
$dataUpdateParent['delegate_commission_percent']=$delegateData['percent_salaes_commission_jomla'];
if($delegateData['percent_type']==1){
$dataUpdateParent['delegate_commission_value']=$delegateData['percent_salaes_commission_jomla']*(-1);;
}else{
$dataUpdateParent['delegate_commission_value']=(($invoice_data['total_cost']*$delegateData['percent_salaes_commission_jomla'])/100)*(-1);
}
}
}
}
$flag = update(new Sales_invoices(), $dataUpdateParent, array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
if ($flag) {
$DelegateData = get_cols_where_row(new Delegate(), array("account_number"), array("com_code" => $com_code, "delegate_code" => $invoice_data['delegate_code']));
if(!empty($DelegateData )){
refresh_account_blance_delegate($DelegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),false);
}
if ($request->what_paid > 0) {
$user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_collect"), array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert_treasuries_transactions['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert_treasuries_transactions['auto_serial'] = 1;
}
$dataInsert_treasuries_transactions['isal_number'] = $treasury_date['last_isal_collect'] + 1;
$dataInsert_treasuries_transactions['shift_code'] = $user_shift['shift_code'];
//Credit دائن
$dataInsert_treasuries_transactions['money'] = $request->what_paid;
$dataInsert_treasuries_transactions['treasuries_id'] = $user_shift['treasuries_id'];
$dataInsert_treasuries_transactions['mov_type'] = 5;
$dataInsert_treasuries_transactions['move_date'] = date("Y-m-d");
if ($invoice_data['is_has_customer'] == 1) {
$dataInsert_treasuries_transactions['account_number'] = $customerData["account_number"];
$dataInsert_treasuries_transactions['is_account'] = 1;
}
$dataInsert_treasuries_transactions['is_approved'] = 1;
$dataInsert_treasuries_transactions['the_foregin_key'] = $request->auto_serial;
//debit دائن
$dataInsert_treasuries_transactions['money_for_account'] = $request->what_paid * (-1);
$dataInsert_treasuries_transactions['byan'] = "تحصيل نظير فاتورة مبيعات  رقم" . $request->auto_serial;
$dataInsert_treasuries_transactions['created_at'] = date("Y-m-Y H:i:s");
$dataInsert_treasuries_transactions['added_by'] = auth()->user()->id;
$dataInsert_treasuries_transactions['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert_treasuries_transactions);
if ($flag) {
//update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_exhcange'] = $dataInsert_treasuries_transactions['isal_number'];
update(new Treasuries(), $dataUpdateTreasuries, array("com_code" => $com_code, "id" => $user_shift['treasuries_id']));
}
}
if ($invoice_data['is_has_customer'] == 1) {
//Affect on Customer Finanical Account Balance
refresh_account_blance_customer($customerData["account_number"], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), false);
}
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
$invoice_data = get_cols_where_row(new Sales_invoices(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($invoice_data)) {
    return redirect()->back()
->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
}

if ($invoice_data['is_approved']==1) {
    return redirect()->back()
->with(['error' => 'عفوا لايمكن حذف فاتورة معتمدة ومؤرشفة !!']);
}
$sales_invoices_details = get_cols_where(new Sales_invoices_details(), array("*"), array("com_code" => $com_code, "sales_invoices_auto_serial" => $invoice_data['auto_serial']));

if(!empty($sales_invoices_details)){
   
    foreach($sales_invoices_details as $item){
   
        $batch_data = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "unit_cost_price", "id"), array("com_code" => $com_code, "auto_serial" => $item->batch_auto_serial));
        if (!empty($batch_data)) {
        $itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit"), array("com_code" => $com_code, "item_code" => $item->item_code));
        if (!empty($itemCard_Data)) {
        $MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
        //حذف السطر من تفاصيل الفاتورة
        $flag = delete(new Sales_invoices_details(), array("com_code" => $com_code, "id" => $item->id));
        if ($flag) {
        //رد الكمية الي الباتش 
        //كمية الصنف بكل المخازن قبل الحركة
        $quantityBeforMove = get_sum_where(
        new Inv_itemcard_batches(),
        "quantity",
        array(
        "item_code" => $item->item_code,
        "com_code" => $com_code
        )
        );
        //get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
        $quantityBeforMoveCurrntStore = get_sum_where(
        new Inv_itemcard_batches(),
        "quantity",
        array(
        "item_code" => $item->item_code, "com_code" => $com_code,
        'store_id' => $item->store_id
        )
        );
        if($item->isparentuom==1){
        //حنرد بشكل مباشر لانه بنفس وحده الباتش الاب
        $item_quantityByParentUom =$item->quantity;
        }else{
        //مرجع بالوحده الابن التجزئة فلازم تحولها الي الاب قبل ردها للمخزن انتبه !!
        $item_quantityByParentUom=$item->quantity/$itemCard_Data['retail_uom_quntToParent'];
        }
        //هنا هنرد الكمية لحظيا الي باتش الصنف
        //update current Batch تحديث علي الباتش القديمة
        $dataUpdateOldBatch['quantity'] = $batch_data['quantity'] + $item_quantityByParentUom;
        $dataUpdateOldBatch['total_cost_price'] = $batch_data['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
        $dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
        $dataUpdateOldBatch["updated_by"] = auth()->user()->id;
        $flag = update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $batch_data['id'], "com_code" => $com_code));
        if ($flag) {
        $quantityAfterMove = get_sum_where(
        new Inv_itemcard_batches(),
        "quantity",
        array(
        "item_code" => $item->item_code,
        "com_code" => $com_code
        )
        );
        //get Quantity Befor any Action  حنجيب كيمة الصنف  بالمخزن المحدد معه   الحالي بعد الحركة
        $quantityAfterMoveCurrentStore = get_sum_where(
        new Inv_itemcard_batches(),
        "quantity",
        array("item_code" => $item->item_code, "com_code" => $com_code, 'store_id' => $item->store_id)
        );
        //التاثير في حركة كارت الصنف
        $dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 2;
        $dataInsert_inv_itemcard_movements['items_movements_types'] = 15;
        $dataInsert_inv_itemcard_movements['item_code'] = $item->item_code;
        //كود الفاتورة الاب
        $dataInsert_inv_itemcard_movements['FK_table'] = $invoice_data['auto_serial'];
        //كود صف الابن بتفاصيل الفاتورة
        $dataInsert_inv_itemcard_movements['FK_table_details'] = $item->id;
        if ($invoice_data['is_has_customer'] == 1) {
        $customerName = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
        } else {
        $customerName = " طياري لايوجد";
        }
        $dataInsert_inv_itemcard_movements['byan'] = "حذف الصنف من تفاصيل  فاتورة مبيعات  للعميل " . " " . $customerName . " فاتورة رقم" . " " . $invoice_data['auto_serial'];
        //كمية الصنف بكل المخازن قبل الحركة
        $dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
        // كمية الصنف بكل المخازن بعد  الحركة
        $dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
        //كمية الصنف  المخزن الحالي قبل الحركة
        $dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
        // كمية الصنف بالمخزن الحالي بعد الحركة الحركة
        $dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
        $dataInsert_inv_itemcard_movements["store_id"] = $item->store_id;
        $dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
        $dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
        $dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
        $dataInsert_inv_itemcard_movements["com_code"] = $com_code;
        $flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
        if ($flag) {
        //update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
        do_update_itemCardQuantity(
        new Inv_itemCard(),
        $item->item_code,
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
}


  

$flag = delete(new Sales_invoices(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
    return redirect()->back()
    ->with(['success' => '   تم حذف البيانات بنجاح']);
    
} else {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
 
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function load_invoice_details_modal(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("*"), array("com_code" => $com_code, "auto_serial" => $request->auto_serial));
$delegates = get_cols_where(new Delegate(), array("delegate_code", "name"), array("com_code" => $com_code, "delegate_code" => $invoice_data['delegate_code']));
if ($invoice_data['is_has_customer'] == 1) {
$customers = get_cols_where(new Customer(), array("customer_code", "name"), array("com_code" => $com_code, "customer_code" => $invoice_data['customer_code']));
}else{
$customers=array();  
}
$Sales_matrial_types = get_cols_where(new Sales_matrial_types(), array("id", "name"), array("com_code" => $com_code, "id" => $invoice_data['sales_matrial_types']));
$sales_invoices_details = get_cols_where(new Sales_invoices_details(), array("*"), array("com_code" => $com_code, "sales_invoices_auto_serial" => $request->auto_serial));
if (!empty($sales_invoices_details)) {
foreach ($sales_invoices_details  as $info) {
$info->store_name = get_field_value(new Store(), "name", array("com_code" => $com_code, "id" => $info->store_id));
$info->item_name = get_field_value(new Inv_itemCard(), "name", array("com_code" => $com_code, "item_code" => $info->item_code));
$info->uom_name = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $info->uom_id));
}
}
return view("admin.sales_invoices.load_invoice_details_modal", ['delegates' => $delegates, 'customers' => $customers, 'Sales_matrial_types' => $Sales_matrial_types, 'invoice_data' => $invoice_data, 'sales_invoices_details' => $sales_invoices_details]);
}
}
public function ajax_search(Request $request)
{
if ($request->ajax()) {
$com_code=auth()->user()->com_code;
$customer_code = $request->customer_code;
$delegates_code = $request->delegates_code;
$Sales_matrial_types = $request->Sales_matrial_types;
$pill_type = $request->pill_type;
$discount_type = $request->discount_type;
$is_approved = $request->is_approved;
$invoice_date_from = $request->invoice_date_from;
$invoice_date_to = $request->invoice_date_to;
$searchbyradio = $request->searchbyradio;
$search_by_text = $request->search_by_text;
if ($customer_code == 'all') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} elseif ($customer_code == "without") {
$field1 = "customer_code";
$operator1 = "=";
$value1 = null;
} else {
$field1 = "customer_code";
$operator1 = "=";
$value1 = $customer_code;
}
if ($discount_type == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} elseif ($discount_type == "without") {
$field2 = "discount_type";
$operator2 = "=";
$value2 = null;
} else {
$field2 = "discount_type";
$operator2 = "=";
$value2 = $discount_type;
}
if ($delegates_code == 'all') {
//دائما  true
$field3 = "id";
$operator3 = ">";
$value3 = 0;
}  else {
$field3 = "delegate_code";
$operator3 = "=";
$value3 = $delegates_code;
}
if ($Sales_matrial_types == 'all') {
//دائما  true
$field4 = "id";
$operator4 = ">";
$value4 = 0;
}  else {
$field4 = "Sales_matrial_types";
$operator4 = "=";
$value4 = $Sales_matrial_types;
}
if ($pill_type == 'all') {
//دائما  true
$field5 = "id";
$operator5 = ">";
$value5 = 0;
}  else {
$field5 = "pill_type";
$operator5 = "=";
$value5 = $pill_type;
}
if ($is_approved == 'all') {
//دائما  true
$field6 = "id";
$operator6 = ">";
$value6 = 0;
}  else {
$field6 = "is_approved";
$operator6 = "=";
$value6 = $is_approved;
}
if ($invoice_date_from == '') {
//دائما  true
$field7 = "id";
$operator7 = ">";
$value7 = 0;
} else {
$field7 = "invoice_date";
$operator7 = ">=";
$value7 = $invoice_date_from;
}
if ($invoice_date_to == '') {
//دائما  true
$field8 = "id";
$operator8 = ">";
$value8 = 0;
} else {
$field8 = "invoice_date";
$operator8 = "<=";
$value8 = $invoice_date_to;
}
if ($search_by_text != '') {
if ($searchbyradio == 'auto_serial') {
$field9 = "auto_serial";
$operator9 = "=";
$value9 = $search_by_text;
} elseif ($searchbyradio == 'customer_code') {
$field9 = "customer_code";
$operator9 = "=";
$value9 = $search_by_text;
}
else {
$field9 = "account_number";
$operator9 = "=";
$value9 = $search_by_text;
}
} else {
//true 
$field9 = "id";
$operator9 = ">";
$value9 = 0;
}
$data = Sales_invoices::where($field1, $operator1, $value1)->
where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where
($field4, $operator4, $value4)->
where($field5, $operator5, $value5)->
where($field6, $operator6, $value6)
->
where($field7, $operator7, $value7)
->
where($field8, $operator8, $value8)->
where($field9, $operator9, $value9)->
orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
$info->Sales_matrial_types_name = get_field_value(new Sales_matrial_types(), "name", array("com_code" => $com_code, "id" => $info->sales_matrial_types));
if ($info->is_has_customer == 1) {
$info->customer_name = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $info->customer_code));
} else {
$info->customer_name = "بدون عميل";
}
}
}
return view('admin.sales_invoices.ajax_search', ['data' => $data]);
}
}
public function do_add_new_customer(Request $request){
if($request->ajax()){
$com_code = auth()->user()->com_code;
//check if not exsits for name
$checkExists_name = get_cols_where_row(new Customer(), array("id"),
array('name' => $request->name, 
'com_code' => $com_code));
if (empty($checkExists_name)) {
//set customer code
$row = get_cols_where_row_orderby(new Customer(), array("customer_code"), 
array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['customer_code'] = $row['customer_code'] + 1;
} else {
$data_insert['customer_code'] = 1;
}
//set account number
$row = get_cols_where_row_orderby(new Account(), array("account_number"),
array("com_code" => $com_code), 'id', 'DESC');
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
$data_insert['phones'] = $request->phones;
$data_insert['current_balance'] = $data_insert['start_balance'];
$data_insert['notes'] = $request->notes;
$data_insert['active'] = $request->active;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new Customer(), $data_insert);
if ($flag) {
//insert into accounts
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
$customer_parent_account_number = get_field_value(new Admin_panel_setting(), "customer_parent_account_number", 
array('com_code' => $com_code));
$data_insert_account['notes'] = $request->notes;
$data_insert_account['parent_account_number'] = $customer_parent_account_number;
$data_insert_account['is_parent'] = 0;
$data_insert_account['account_number'] = $data_insert['account_number'];
$data_insert_account['account_type'] = 3;
$data_insert_account['active'] = $request->active;
$data_insert_account['added_by'] = auth()->user()->id;
$data_insert_account['created_at'] = date("Y-m-d H:i:s");
$data_insert_account['date'] = date("Y-m-d");
$data_insert_account['com_code'] = $com_code;
$data_insert_account['other_table_FK'] = $data_insert['customer_code'];
$flag = insert(new Account(), $data_insert_account);
if($flag){
echo json_encode("done");
}
}
}else{
echo json_encode('exsits');
}
}
}
public function get_last_added_customer(Request $request){
if($request->ajax()){
$com_code=auth()->user()->com_code;
$customers=get_cols_where_limit(new Customer(),array("customer_code","name"),array("com_code"=>$com_code),'id','DESC',1);
return view('admin.sales_invoices.get_last_added_customer',['customers'=>$customers]);
}
}
public function searchforcustomer(Request $request){
if($request->ajax()){
$com_code=auth()->user()->com_code;
$searchtext=$request->searchtext;
if($searchtext!=""){
$customers=Customer::where('name','like',"%{$searchtext}%")->orWhere('customer_code','=',$searchtext)->orderby('id','asc')->limit(10)->get();
if(!empty($customers)){
    foreach($customers as $info){
        $info->SalesInvoicesCounter=get_count_where(new Sales_invoices(),array("customer_code"=>$info->customer_code,'com_code'=>$com_code));
    }
}

}else{
$customers=array();
}
return view('admin.sales_invoices.get_searchforcustomer_result',['customers'=>$customers]);
}
}
public function searchforitems(Request $request){
if($request->ajax()){
$com_code=auth()->user()->com_code;
$searchtext=$request->searchtext;
if($searchtext!=""){
$item_cards=Inv_itemCard::where('name','like',"%{$searchtext}%")->orWhere('barcode','like',"%{$searchtext}%")->orWhere('item_code','=',$searchtext)->orderby('id','asc')->limit(10)->get();
}else{
$item_cards=array();
}
return view('admin.sales_invoices.searchforitemsResult',['item_cards'=>$item_cards]);
}
}
public function printsaleswina4($id,$size){
$com_code = auth()->user()->com_code;
$invoice_data = get_cols_where_row(new Sales_invoices(), array("*"), array("com_code" => $com_code, "id" => $id));
if(empty($invoice_data)){
return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي البيانات المطلوبة']);
}
$invoice_data['customer_name']=get_field_value(new Customer(),'name',array("com_code"=>$com_code,"customer_code"=>$invoice_data['customer_code']));
$invoice_data['customer_phones']=get_field_value(new Customer(),'phones',array("com_code"=>$com_code,"customer_code"=>$invoice_data['customer_code']));
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$sales_invoices_details = get_cols_where(new Sales_invoices_details(), array("*"), array("com_code" => $com_code, "sales_invoices_auto_serial" => $invoice_data['auto_serial']));
if (!empty($sales_invoices_details)) {
foreach ($sales_invoices_details  as $info) {
$info->store_name = get_field_value(new Store(), "name", array("com_code" => $com_code, "id" => $info->store_id));
$info->item_name = get_field_value(new Inv_itemCard(), "name", array("com_code" => $com_code, "item_code" => $info->item_code));
$info->uom_name = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $info->uom_id));
}
}
if($size=="A4"){
    return view('admin.sales_invoices.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$sales_invoices_details]);
}else{
    return view('admin.sales_invoices.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$sales_invoices_details]);

}
}
}
