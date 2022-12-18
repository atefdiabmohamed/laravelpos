<?php
//لاتنسونا من صالح الدعاء
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Inv_stores_inventory;
use App\Models\Inv_stores_inventory_details;
use App\Models\Store;
use App\Models\Inv_itemCard;
use App\Http\Requests\Inv_stores_inventoryRequest;
use App\Models\Inv_itemcard_batches;
use App\Models\Inv_uom;
use App\Models\Inv_itemcard_movements;




class Inv_stores_inventoryController extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Inv_stores_inventory(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
$info->store_name = Store::where('id', $info->store_id)->value('name');
}
}
}
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code,'active'=>1), 'id', 'ASC');
return view('admin.inv_stores_inventory.index', ['data' => $data, 'stores' => $stores]);
}
public function create()
{
$com_code = auth()->user()->com_code;
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code,'active'=>1), 'id', 'ASC');
return view('admin.inv_stores_inventory.create', ['stores' => $stores]);
}
public function store(Inv_stores_inventoryRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$counter_opnened_for_store = get_count_where(new Inv_stores_inventory(), array("com_code" => $com_code,'store_id'=>$request->store_id,'is_closed'=>0));
if($counter_opnened_for_store>0){
return redirect()->back()
->with(['error' => 'عفوا يوجد بالفعل أمر جرد مفتوح لهذا المخزن' ])
->withInput();
}
$row = get_cols_where_row_orderby(new Inv_stores_inventory(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['inventory_date'] = $request->inventory_date;
$data_insert['inventory_type'] = $request->inventory_type;
$data_insert['store_id'] = $request->store_id;
$data_insert['notes'] = $request->notes;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
insert(new Inv_stores_inventory(),$data_insert);
return redirect()->route("admin.stores_inventory.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
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
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed'] == 1) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا لايمكن التحديث علي امر جرد مغلق ومرحل  ']);
}
$counterAddedDetails=get_count_where(new Inv_stores_inventory_details(),array("inv_stores_inventory_auto_serial"=>$data['auto_serial'],'com_code'=>$com_code,'is_closed'=>1));
if ($counterAddedDetails > 0) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا لايمكن التحديث علي امر جرد قد تم اعتماد اصناف عليه  ']);
}
$flag = delete(new Inv_stores_inventory(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
delete(new Inv_stores_inventory_details(), array("inv_stores_inventory_auto_serial" => $data['auto_serial'], "com_code" => $com_code));
return redirect()->route('admin.stores_inventory.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed'] == 1) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا لايمكن التحديث علي امر جرد مغلق ومرحل  ']);
}
$counterAddedDetails=get_count_where(new Inv_stores_inventory_details(),array("inv_stores_inventory_auto_serial"=>$data['auto_serial'],'com_code'=>$com_code));
if($counterAddedDetails==0){
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code,'active'=>1), 'id', 'ASC');
}else{
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code,'id'=>$data['store_id']), 'id', 'ASC');
}
return view('admin.inv_stores_inventory.edit', ['data' => $data,'stores'=>$stores]);
}
public function update($id, Inv_stores_inventoryRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed'] == 1) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا لايمكن التحديث علي امر جرد مغلق ومرحل  ']);
}
$counterSameStoreOpened=Inv_stores_inventory::where('id','!=',$id)->where('com_code','=',$com_code)->where('store_id','=',$request->store_id)->count();
if($counterSameStoreOpened>0){
return redirect()->back()
->with(['error' => 'عفوا  هناك امر جرد مازال مفتوح مع هذه المخزن '] )
->withInput();
}
$counterAddedDetails=get_count_where(new Inv_stores_inventory_details(),array("inv_stores_inventory_auto_serial"=>$data['auto_serial'],'com_code'=>$com_code));
if($counterAddedDetails==0){
$data_to_update['store_id'] = $request->store_id;
}
$data_to_update['inventory_date'] = $request->inventory_date;
$data_to_update['inventory_type'] = $request->inventory_type;
$data_to_update['notes'] = $request->notes;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new Inv_stores_inventory(), $data_to_update, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.stores_inventory.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}
$details = get_cols_where(new inv_stores_inventory_details(), array("*"), array('inv_stores_inventory_auto_serial' => $data['auto_serial'], 'com_code' => $com_code), 'id', 'DESC');
if (!empty($details)) {
foreach ($details as $info) {
$info->item_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->item_type = Inv_itemCard::where('item_code', $info->item_code)->value('item_type');

$data['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by> 0 and $info->updated_by != null) {
$data['updated_by_admin'] = Admin::where('id', $info->updated_by)->value('name');
}
}
}
if($data['is_closed']==0){
$items_in_store=Inv_itemcard_batches::where("com_code","=",$com_code)->where("store_id","=",$data['store_id'])->orderby('item_code','ASC')->distinct()->get(['item_code']);
if (!empty($items_in_store)) {
foreach ($items_in_store as $info) {
$info->name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
}
}
}
return view("admin.inv_stores_inventory.show", ['data' => $data, 'details' => $details,'items_in_store'=>$items_in_store]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
public function add_new_details($id,Request $request)
{
if ($_POST) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed']==1) {
return redirect()->route('admin.stores_inventory.show',$id)->with(['error' => 'عفوا لايمكن الاضافة علي امر جرد مغلق ومرحل !']);
}
if($_POST['does_add_all_items']==1){
$items_in_store=Inv_itemcard_batches::where("com_code","=",$com_code)->where("store_id","=",$data['store_id'])->orderby('item_code','ASC')->distinct()->get(['item_code']);
}else{
$items_in_store=Inv_itemcard_batches::where("com_code","=",$com_code)->where("store_id","=",$data['store_id'])->where('item_code','=',$_POST['items_in_store'])->orderby('item_code','ASC')->distinct()->get(['item_code']);
}
if(!empty($items_in_store)){
foreach($items_in_store as $info){
if($_POST['dose_enter_empty_batch']==1){
$info->Batches=Inv_itemcard_batches::select("*")->where("com_code",'=',$com_code)->where('item_code','=',$info->item_code)->where('store_id','=',$data['store_id'])->get();
}else{
$info->Batches=Inv_itemcard_batches::select("*")->where("com_code",'=',$com_code)->where('item_code','=',$info->item_code)->where('store_id','=',$data['store_id'])->where('quantity','>',0);
}
if(!empty( $info->Batches)){
foreach( $info->Batches as $batch){
$counter=get_count_where(new Inv_stores_inventory_details(),array("com_code"=>$com_code,"inv_stores_inventory_auto_serial"=>$data['auto_serial'],'batch_auto_serial'=>$batch->auto_serial,'item_code'=>$batch->item_code));
if($counter==0){
$data_insert['inv_stores_inventory_auto_serial'] = $data['auto_serial'];
$data_insert['batch_auto_serial'] = $batch->auto_serial;
$data_insert['item_code'] = $batch->item_code;
$data_insert['inv_uoms_id'] = $batch->inv_uoms_id;
$data_insert['unit_cost_price'] = $batch->unit_cost_price;
$data_insert['old_quantity'] = $batch->quantity;
$data_insert['new_quantity'] = $batch->quantity;
$data_insert['total_cost_price'] = $batch->total_cost_price;
$data_insert['production_date'] = $batch->production_date;
$data_insert['expired_date'] = $batch->expired_date;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
$flag = insert(new Inv_stores_inventory_details(), $data_insert);
}
}
}

}
}
$data_to_update_parent['total_cost_batches']=get_sum_where(new Inv_stores_inventory_details(),'total_cost_price',array("com_code"=>$com_code,'inv_stores_inventory_auto_serial'=>$data['auto_serial']));
update(new Inv_stores_inventory(),$data_to_update_parent,array("com_code"=>$com_code,"id" => $id,'is_closed'=>0));

}

return redirect()->route('admin.stores_inventory.show',$id)->with(['success' => 'تم اضافة البيانات بنجاح']);
}

public function load_edit_item_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $request->id_parent_pill, "com_code" => $com_code));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_closed'] == 0) {
$item_data_detials = get_cols_where_row(new Inv_stores_inventory_details(), array("*"), array("inv_stores_inventory_auto_serial" => $parent_pill_data['auto_serial'], "com_code" => $com_code, 'id' => $request->id));
return view("admin.inv_stores_inventory.load_edit_item_details", ['parent_pill_data' => $parent_pill_data, 'item_data_detials' => $item_data_detials]);
}
}
}
}


public function edit_item_details($id,$parent_pill_id,Request $request)
{
if ($_POST) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_stores_inventory(), array("*"), array("id" => $parent_pill_id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed']==1) {
return redirect()->route('admin.stores_inventory.show',$parent_pill_id)->with(['error' => 'عفوا لايمكن الاضافة علي امر جرد مغلق ومرحل !']);
}

$dataDetails = get_cols_where_row(new Inv_stores_inventory_details(), array("*"), array("id" => $id, "com_code" => $com_code,'inv_stores_inventory_auto_serial'=>$data['auto_serial']));
if (empty($dataDetails)) {
return redirect()->route('admin.stores_inventory.show',$parent_pill_id)->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($dataDetails['is_closed']==1) {
return redirect()->route('admin.stores_inventory.show',$parent_pill_id)->with(['error' => 'عفوا لايمكن تحديث علي صنف جرد مغلق ومرحل !']);
}
$dataUpdateDetails['new_quantity']=$request->new_quantity_edit;
$dataUpdateDetails['diffrent_quantity']=($request->new_quantity_edit-$dataDetails['old_quantity']);
$dataUpdateDetails['total_cost_price']=($request->new_quantity_edit*$dataDetails['unit_cost_price']);

$dataUpdateDetails['notes']=$request->notes_edit;
$dataUpdateDetails['updated_by'] = auth()->user()->id;
$dataUpdateDetails['updated_at'] = date("Y-m-d H:i:s");
update(new Inv_stores_inventory_details(),$dataUpdateDetails,array("com_code"=>$com_code,"id" => $id,'is_closed'=>0,'inv_stores_inventory_auto_serial'=>$data['auto_serial']));
$data_to_update_parent['total_cost_batches']=get_sum_where(new Inv_stores_inventory_details(),'total_cost_price',array("com_code"=>$com_code,'inv_stores_inventory_auto_serial'=>$data['auto_serial']));
update(new Inv_stores_inventory(),$data_to_update_parent,array("com_code"=>$com_code,"id" => $parent_pill_id,'is_closed'=>0));


}

return redirect()->route('admin.stores_inventory.show',$parent_pill_id)->with(['success' => 'تم تحديث البيانات بنجاح']);
}

public function delete_details($id,$id_parent)
{
try {
$com_code = auth()->user()->com_code;
$data_parent = get_cols_where_row(new Inv_stores_inventory(), array("is_closed","auto_serial"), array("id" => $id_parent, "com_code" => $com_code));
if (empty($data_parent)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data_parent['is_closed'] == 1) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا لايمكن التحديث علي امر جرد مغلق ومرحل  ']);
}
$Data_item_details=get_cols_where_row(new Inv_stores_inventory_details(),array("is_closed"),array("id"=>$id,'com_code'=>$com_code,'inv_stores_inventory_auto_serial'=>$data_parent['auto_serial']));
if (empty($Data_item_details)) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($Data_item_details['is_closed'] == 1) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا لايمكن التحديث علي امر جرد لصنف مغلق ومرحل  ']);
}

$flag = delete(new Inv_stores_inventory_details(), array("id"=>$id,'com_code'=>$com_code,'inv_stores_inventory_auto_serial'=>$data_parent['auto_serial'],'is_closed'=>0));
if ($flag) {
    $data_to_update_parent['total_cost_batches']=get_sum_where(new Inv_stores_inventory_details(),'total_cost_price',array("com_code"=>$com_code,'inv_stores_inventory_auto_serial'=>$data_parent['auto_serial']));
update(new Inv_stores_inventory(),$data_to_update_parent,array("com_code"=>$com_code,"id" => $id_parent,'is_closed'=>0));

return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function close_one_details($id,$id_parent)
{
try {
$com_code = auth()->user()->com_code;
$data_parent = get_cols_where_row(new Inv_stores_inventory(), array("is_closed","auto_serial","store_id"), array("id" => $id_parent, "com_code" => $com_code));
if (empty($data_parent)) {
return redirect()->route('admin.stores_inventory.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data_parent['is_closed'] == 1) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا لايمكن التحديث علي امر جرد مغلق ومرحل  ']);
}
$Data_item_details=get_cols_where_row(new Inv_stores_inventory_details(),array("*"),array("id"=>$id,'com_code'=>$com_code,'inv_stores_inventory_auto_serial'=>$data_parent['auto_serial']));
if (empty($Data_item_details)) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($Data_item_details['is_closed'] == 1) {
    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['error' => 'عفوا لايمكن التحديث علي امر جرد لصنف مغلق ومرحل  ']);
}
//first we update Old pathc with new quantity

//كمية الصنف بكل المخازن قبل الحركة
$quantityBeforMove = get_sum_where(
    new Inv_itemcard_batches(),
    "quantity",
    array(
        "item_code" => $Data_item_details['item_code'], "com_code" => $com_code
    )
    );
//get Quantity Befor any Action  حنجيب كمية الصنف  بالمخزن المحدد معه   الحالي قبل الحركة
$quantityBeforMoveCurrntStore = get_sum_where(
    new Inv_itemcard_batches(),
    "quantity",
    array(
    "item_code" => $Data_item_details['item_code'], "com_code" => $com_code,
    'store_id' => $data_parent['store_id']
    )
    );


    $dataUpdateBatch['quantity']=$Data_item_details['new_quantity'];
    $dataUpdateBatch['total_cost_price']=$Data_item_details['total_cost_price'];
    $dataUpdateBatch['updated_by'] = auth()->user()->id;
    $dataUpdateBatch['updated_at'] = date("Y-m-d H:i:s");
    $flag=update(new Inv_itemcard_batches(),$dataUpdateBatch,array("com_code" => $com_code,'auto_serial'=>$Data_item_details['batch_auto_serial'],'item_code'=>$Data_item_details['item_code']));
    if( $flag){
        $dataUpdatedetails['is_closed']=1;
        $dataUpdatedetails['cloased_by'] = auth()->user()->id;
        $dataUpdatedetails['closed_at'] = date("Y-m-d H:i:s");
        $flag= update(new Inv_stores_inventory_details(),$dataUpdatedetails,array("id"=>$id,'com_code'=>$com_code,'inv_stores_inventory_auto_serial'=>$data_parent['auto_serial']));
       if($flag){
   
//كمية الصنف بكل المخازن بعد الحركة
$quantityAfterMove = get_sum_where(
    new Inv_itemcard_batches(),
    "quantity",
    array(
        "item_code" => $Data_item_details['item_code'], "com_code" => $com_code
    )
    );
//كمية الصنف  بالمخزن الحالي بعد الحركة
$quantityAfterMoveCurrentStore = get_sum_where(
    new Inv_itemcard_batches(),
    "quantity",
    array(
    "item_code" => $Data_item_details['item_code'], "com_code" => $com_code,
    'store_id' => $data_parent['store_id']
    )
    );

    $MainUomName = get_field_value(new Inv_uom(), "name", array("com_code" => $com_code, "id" => $Data_item_details['inv_uoms_id']));

    $itemCard_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "retail_uom_quntToParent", "retail_uom_id", "does_has_retailunit"), array("com_code" => $com_code, "item_code" => $Data_item_details['item_code']));

//التاثير في حركة كارت الصنف
$dataInsert_inv_itemcard_movements['inv_itemcard_movements_categories'] = 3;
$dataInsert_inv_itemcard_movements['items_movements_types'] = 6;
$dataInsert_inv_itemcard_movements['item_code'] = $Data_item_details['item_code'];
//كود الفاتورة الاب
$dataInsert_inv_itemcard_movements['FK_table'] = $data_parent['auto_serial'];
//كود صف الابن بتفاصيل الفاتورة
$dataInsert_inv_itemcard_movements['FK_table_details'] = $Data_item_details['id'];

$dataInsert_inv_itemcard_movements['byan'] = "جرد بالمخازن للباتش رقم" . " " . $Data_item_details['batch_auto_serial'] . " جرد رقم" . " " . $data_parent['auto_serial'];
//كمية الصنف بكل المخازن قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_movement'] = "عدد " . " " . ($quantityBeforMove * 1) . " " . $MainUomName;
// كمية الصنف بكل المخازن بعد  الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move'] = "عدد " . " " . ($quantityAfterMove * 1) . " " . $MainUomName;
//كمية الصنف  المخزن الحالي قبل الحركة
$dataInsert_inv_itemcard_movements['quantity_befor_move_store'] = "عدد " . " " . ($quantityBeforMoveCurrntStore * 1) . " " . $MainUomName;
// كمية الصنف بالمخزن الحالي بعد الحركة الحركة
$dataInsert_inv_itemcard_movements['quantity_after_move_store'] = "عدد " . " " . ($quantityAfterMoveCurrentStore * 1) . " " . $MainUomName;
$dataInsert_inv_itemcard_movements["store_id"] = $data_parent['store_id'];
$dataInsert_inv_itemcard_movements["created_at"] = date("Y-m-d H:i:s");
$dataInsert_inv_itemcard_movements["added_by"] = auth()->user()->id;
$dataInsert_inv_itemcard_movements["date"] = date("Y-m-d");
$dataInsert_inv_itemcard_movements["com_code"] = $com_code;
$flag = insert(new Inv_itemcard_movements(), $dataInsert_inv_itemcard_movements);
if ($flag) {
//update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
do_update_itemCardQuantity(
new Inv_itemCard(),
$Data_item_details['item_code'],
new Inv_itemcard_batches(),
$itemCard_Data['does_has_retailunit'],
$itemCard_Data['retail_uom_quntToParent']
);

}







       }

    }




    return redirect()->route('admin.stores_inventory.show',$id_parent)->with(['success' => 'لقد تم ترحيل الباتش بنجاح']);




} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


}