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
}