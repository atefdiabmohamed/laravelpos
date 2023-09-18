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
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class Inv_stores_transferIncomingController extends Controller
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
return view('admin.inv_stores_transfer_incoming.index', ['data' => $data, 'stores' => $stores]);
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
return view("admin.inv_stores_transfer_incoming.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
//اعتماد واستلام كمية صنف 
function approve_one_details($id,$id_parent, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
$data = get_cols_where_row(new inv_stores_transfer(), array( "auto_serial", "transfer_from_store_id", "transfer_to_store_id", "is_approved"), array("id" => $id_parent, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route("admin.inv_stores_transfer_incoming.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($data['is_approved'] == 1) {
return redirect()->route("admin.suppliers_orders.show", $id_parent)->with(['error' => "عفوا لايمكن اعتماد فاتورة معتمده من قبل !!"]);
}
$dataDetails = get_cols_where_row(new inv_stores_transfer_details(), array( "is_approved"), array("id" => $id, "com_code" => $com_code));
if (empty($dataDetails)) {
return redirect()->route("admin.inv_stores_transfer_incoming.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($dataDetails['is_approved'] == 1) {
return redirect()->route("admin.inv_stores_transfer_incoming.show", $id_parent)->with(['error' => "عفوا لايمكن اعتماد صنف تم اعتمادة من   قبل !!"]);
}
//store move حركة مخزن الاستلام
//first Get item card data جنجيب الاصناف بالكود الحالي  علي امر التحويل
$items = get_cols_where(new inv_stores_transfer_details(), array("*"), array("inv_stores_transfer_auto_serial" => $data['auto_serial'], "com_code" => $com_code, "id" => $id), "id", "ASC");
if (!empty($items)) {
foreach ($items as $info) {
//get itemCard Data
$itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit"), array("com_code" => $com_code, "item_code" => $info->item_code));
if (!empty($itemCard_Data)) {
//get Quantity Befor any Action  حنجيب كيمة الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(new Inv_itemcard_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code));
//get Quantity Befor any Action  حنجيب كيمة الصنف  بمخزن الاستلام المشتريات الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(new Inv_itemcard_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $data['transfer_to_store_id']));
$MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $itemCard_Data['uom_id']));
//if is parent Uom لو وحده اب
if ($info->isparentuom == 1) {
$quntity = $info->deliverd_quantity;
$unit_price = $info->unit_price;
} else {
// if is retail  لو كان بوحده الابن التجزئة
//التحويل من الاب للابن بنضرب   في النسبة بينهم - اما التحويل من الابن للاب بنقسم علي النسبه بينهما 
$quntity = ($info->deliverd_quantity / $itemCard_Data['retail_uom_quntToParent']);
$unit_price = $info->unit_price * $itemCard_Data['retail_uom_quntToParent'];
}
//بندخل الكميات للمخزن بوحده القياس الاب  اجباري 
$dataInsertBatch["store_id"] = $data['transfer_to_store_id'];
$dataInsertBatch["item_code"] = $info->item_code;
$dataInsertBatch["production_date"] = $info->production_date;
$dataInsertBatch["expired_date"] = $info->expire_date;
$dataInsertBatch["unit_cost_price"] = $unit_price;
$dataInsertBatch["inv_uoms_id"] = $itemCard_Data['uom_id'];
$OldBatchExsists = get_cols_where_row(new Inv_itemcard_batches(), array("quantity", "id", "unit_cost_price"), $dataInsertBatch);
if (!empty($OldBatchExsists)) {
//update current Batch تحديث علي الباتش القديمة
$dataUpdateOldBatch['quantity'] = $OldBatchExsists['quantity'] + $quntity;
$dataUpdateOldBatch['total_cost_price'] = $OldBatchExsists['unit_cost_price'] * $dataUpdateOldBatch['quantity'];
$dataUpdateOldBatch["updated_at"] = date("Y-m-d H:i:s");
$dataUpdateOldBatch["updated_by"] = auth()->user()->id;
$theBatchID=$OldBatchExsists['id'];
update(new Inv_itemcard_batches(), $dataUpdateOldBatch, array("id" => $OldBatchExsists['id'], "com_code" => $com_code));
} else {
//insert new Batch ادخال باتش جديده
$dataInsertBatch["quantity"] = $quntity;
$dataInsertBatch["total_cost_price"] = $info->total_price;
$dataInsertBatch["created_at"] = date("Y-m-d H:i:s");
$dataInsertBatch["added_by"] = auth()->user()->id;
$dataInsertBatch["com_code"] = $com_code;
$row = get_cols_where_row_orderby(new Inv_itemcard_batches(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$dataInsertBatch['auto_serial'] = $row['auto_serial'] + 1;
} else {
$dataInsertBatch['auto_serial'] = 1;
}
insert(new Inv_itemcard_batches(), $dataInsertBatch);
$theBatchID=get_field_value(new Inv_itemcard_batches(),'auto_serial',$dataInsertBatch);
}
$dataToUpdateDetails['is_approved']=1;
$dataToUpdateDetails['approved_by']=auth()->user()->id;
$dataToUpdateDetails['approved_at']=date("Y-m-d H:i:s");
update(new inv_stores_transfer_details(),$dataToUpdateDetails,array("id"=>$id,"com_code"=>$com_code));
//كمية الصنف بكل المخازن بعد اتمام حركة الباتشات وترحيلها
$quantityAfterMove = get_sum_where(new Inv_itemcard_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code));
//كمية الصنف بمخزن فاتورة الشراء  بعد اتمام حركة الباتشات وترحيلها
$quantityAfterMoveCurrentStore = get_sum_where(new Inv_itemcard_batches(), "quantity", array("item_code" => $info->item_code, "com_code" => $com_code, 'store_id' => $data['transfer_to_store_id']));
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 3;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 22;
$dataInsert_inv_itemcard_movements['item_code'] = $info->item_code;
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $data['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $info->id;
$from_store_name = Store::where('id', $data['transfer_from_store_id'])->value('name');
$dataInsert_inv_itemcard_movements['byan'] = "نظير اعتماد واستلام امر تحويل وارد من المخزن   " . " " . $from_store_name . " امر تحويل رقم" . " " . $data['auto_serial'];
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $data['transfer_to_store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
//item Move Card حركة الصنف 
}
// update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(new Inv_itemCard(), $info->item_code, new Inv_itemcard_batches(), $itemCard_Data['does_has_retailunit'], $itemCard_Data['retail_uom_quntToParent']);
}
}
return redirect()->route("admin.inv_stores_transfer_incoming.show", $id_parent)->with(['success' => " تم اعتماد واستلام كمية الصنف  بنجاح  "]);
}
public function load_cancel_one_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new inv_stores_transfer(), array("is_approved","id"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code,"is_approved"=>0));
$data = get_cols_where_row(new inv_stores_transfer_details(), array("is_approved","id"), array("id" => $request->id, "com_code" => $com_code,"is_approved"=>0,"is_canceld_receive"=>0));
return view("admin.inv_stores_transfer_incoming.load_cancel_one_details", ['parent_pill_data' => $parent_pill_data, 'data' => $data]);
}
}
//اعتماد وترحيل فاتورة المشتريات 
function do_cancel_one_details($id,$id_parent, Request $request)
{
$com_code = auth()->user()->com_code;
//check is not approved 
$data = get_cols_where_row(new inv_stores_transfer(), array( "auto_serial", "transfer_from_store_id", "transfer_to_store_id", "is_approved"), array("id" => $id_parent, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route("admin.inv_stores_transfer_incoming.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($data['is_approved'] == 1) {
return redirect()->route("admin.suppliers_orders.show", $id_parent)->with(['error' => "عفوا لايمكن اعتماد فاتورة معتمده من قبل !!"]);
}
$dataDetails = get_cols_where_row(new inv_stores_transfer_details(), array( "is_approved"), array("id" => $id, "com_code" => $com_code));
if (empty($dataDetails)) {
return redirect()->route("admin.inv_stores_transfer_incoming.index")->with(['error' => "عفوا غير قادر علي الوصول الي البيانات المطلوبة !!"]);
}
if ($dataDetails['is_approved'] == 1) {
return redirect()->route("admin.inv_stores_transfer_incoming.show", $id_parent)->with(['error' => "عفوا لايمكن اعتماد صنف تم اعتمادة من   قبل !!"]);
}
if ($dataDetails['is_canceld_receive'] == 1) {
return redirect()->route("admin.inv_stores_transfer_incoming.show", $id_parent)->with(['error' => "عفوا لايمكن اعتماد صنف تم اعتمادة من   قبل !!"]);
}
$dataToUpdateDetails['canceld_cause']=$request->canceld_cause;
$dataToUpdateDetails['is_canceld_receive']=1;
$dataToUpdateDetails['canceld_by']=auth()->user()->id;
$dataToUpdateDetails['canceld_at']=date("Y-m-d H:i:s");
update(new inv_stores_transfer_details(),$dataToUpdateDetails,array("id"=>$id,"com_code"=>$com_code));
return redirect()->route("admin.inv_stores_transfer_incoming.show", $id_parent)->with(['success' => "لقد تم الالغاء  بنجاح"]);
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
return view('admin.inv_stores_transfer_incoming.ajax_search', ['data' => $data]);
}
}

public function printsaleswina4($id,$size){

    try {
    $com_code = auth()->user()->com_code;
    $invoice_data = get_cols_where_row(new inv_stores_transfer(), array("*"), array("id" => $id, "com_code" => $com_code));
    if (empty($invoice_data)) {
    return redirect()->route('admin.inv_stores_transfer_incoming.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
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
        return view('admin.inv_stores_transfer_incoming.printsaleswina4',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
    }else{
        return view('admin.inv_stores_transfer_incoming.printsaleswina6',['data'=>$invoice_data,'systemData'=>$systemData,'sales_invoices_details'=>$invoices_details]);
    
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
    }
    



}