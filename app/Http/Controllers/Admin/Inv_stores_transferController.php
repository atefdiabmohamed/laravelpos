<?php

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




}
