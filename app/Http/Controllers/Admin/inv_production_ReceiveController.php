<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\inv_production_receive;
use App\Models\inv_production_receive_details;
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
use Illuminate\Http\Request;
use App\Http\Requests\Inv_production_ReceiveRequest;

class inv_production_ReceiveController extends Controller
{
    
    public function index()
    { 
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new inv_production_receive(), array("*"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC', PAGINATION_COUNT);
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
    return view('admin.inv_production_Receive.index', ['data' => $data, 'Inv_production_lines' => $Inv_production_lines, 'stores' => $stores]);
    }  


    public function create()
    {
    $com_code = auth()->user()->com_code;
    $Inv_production_lines = get_cols_where(new Inv_production_lines(), array('production_lines_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'ASC');
    $stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    $Inv_production_order = get_cols_where(new Inv_production_order(), array( 'auto_serial'), array('com_code' => $com_code, 'is_closed' => 0,'is_approved'=>1), 'id', 'DESC');
    return view('admin.inv_production_Receive.create', ['Inv_production_lines' => $Inv_production_lines, 'stores' => $stores,'Inv_production_order'=>$Inv_production_order]);
    }
    public function store(Inv_production_ReceiveRequest $request)
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
    $row = get_cols_where_row_orderby(new inv_production_receive(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC');
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
    $data_insert['com_code'] = $com_code;//كود الشركه او كود الفرع
    insert(new inv_production_receive(),$data_insert);
    //$id = get_field_value(new Suppliers_with_orders(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => 3));
    return redirect()->route("admin.inv_production_Receive.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
    ->withInput();
    }
    }
    
    
public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_production_receive(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$Inv_production_lines = get_cols_where(new Inv_production_lines(), array('production_lines_code', 'name'), array('com_code' => $com_code), 'id', 'ASC');
$stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code), 'id', 'DESC');
$Inv_production_order = get_cols_where(new Inv_production_order(), array( 'auto_serial'), array('com_code' => $com_code, 'is_closed' => 0,'is_approved'=>1), 'id', 'DESC');
return view('admin.inv_production_Receive.edit', ['data' => $data, 'Inv_production_lines' => $Inv_production_lines, 'stores' => $stores,'Inv_production_order'=>$Inv_production_order]);
}


public function update($id, Inv_production_ReceiveRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_production_receive(), array("is_approved","auto_serial"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_approved'] == 1) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
$data_Inv_production_line = get_cols_where_row(new Inv_production_lines(), array("account_number"), array("production_lines_code" => $request->production_lines_code, "com_code" => $com_code));
if (empty($data_Inv_production_line)) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا غير قادر علي الوصول الي  بيانات خط الانتاج !!']);
}

$data_to_update['store_id'] = $request->store_id;
$data_to_update['production_lines_code'] = $request->production_lines_code;
$data_to_update['account_number'] = $data_Inv_production_line['account_number'];
$data_to_update['order_date'] = $request->order_date;
$data_to_update['notes'] = $request->notes;
$data_to_update['inv_production_order_auto_serial'] = $request->inv_production_order_auto_serial;
$data_to_update['pill_type'] = $request->pill_type;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new inv_production_receive(), $data_to_update, array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
return redirect()->route('admin.inv_production_Receive.show',$id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$parent_pill_data = get_cols_where_row(new inv_production_receive(), array("is_approved", "auto_serial","store_id","production_lines_code"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
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

$flag = delete(new inv_production_receive(), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if ($flag) {
    //حذف التفاصيل المضافة علي الفاتورة - ملحوظة هي بالفعل تم حذفها من خلال العلاقة بقاعده البيانات بين الجدولين
 delete(new inv_production_receive_details(), array("inv_production_receive_auto_serial" => $parent_pill_data['auto_serial'], "com_code" => $com_code, 'order_type' => 1));


}
return redirect()->route('admin.inv_production_Receive.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);

} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}


public function show($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new inv_production_receive(), array("*"), array("id" => $id, "com_code" => $com_code, 'order_type' => 1));
if (empty($data)) {
return redirect()->route('admin.inv_production_Receive.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$data['added_by_admin'] = Admin::where('id', $data['added_by'])->value('name');
$data['production_lines_name'] = Inv_production_lines::where('production_lines_code', $data['production_lines_code'])->value('name');
$data['store_name'] = Store::where('id', $data['store_id'])->value('name');
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}

$details = get_cols_where(new inv_production_receive_details(), array("*"), array('inv_production_receive_auto_serial' => $data['auto_serial'], 'order_type' => 1, 'com_code' => $com_code), 'id', 'DESC');
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
return view("admin.inv_production_receive.show", ['data' => $data, 'details' => $details]);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function load_modal_add_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$parent_pill_data = get_cols_where_row(new inv_production_receive(), array("is_approved"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$item_cards = get_cols_where(new Inv_itemCard(), array("name", "item_code", "item_type"), array('active' => 1, 'com_code' => $com_code), 'id', 'DESC');
}
}
return view("admin.inv_production_receive.load_add_new_itemdetails", ['parent_pill_data' => $parent_pill_data, 'item_cards' => $item_cards]);

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
return view("admin.inv_production_receive.get_item_uoms", ['item_card_Data' => $item_card_Data]);
}
}

public function add_new_details(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$item_code = $request->item_code;
$parent_pill_data = get_cols_where_row(new inv_production_receive(), array("is_approved", "order_date", "tax_value", "discount_value","id"), array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
if (!empty($parent_pill_data)) {
if ($parent_pill_data['is_approved'] == 0) {
$data_insert['inv_production_receive_auto_serial'] = $request->autoserailparent;
$data_insert['order_type'] = 1;
$data_insert['inv_production_receive_id'] = $parent_pill_data['id'];
$data_insert['item_code'] = $request->item_code_add;
$data_insert['deliverd_quantity'] = $request->quantity_add;
$data_insert['unit_price'] = $request->price_add;
$data_insert['uom_id'] = $request->uom_id_Add;
$data_insert['isparentuom'] = $request->isparentuom;
if ($request->type == 2) {
$data_insert['production_date'] = $request->production_date;
$data_insert['expire_date'] = $request->expire_date;
}
$data_insert['item_card_type'] = $request->type;
$data_insert['total_price'] = $request->total_add;
$data_insert['order_date'] = $parent_pill_data['order_date'];
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['com_code'] = $com_code;
$flag = insert(new inv_production_receive_details(), $data_insert);
if ($flag) {
/** update parent pill */
$total_detials_sum = get_sum_where(new inv_production_receive_details(), 'total_price', array("inv_production_receive_auto_serial" => $request->autoserailparent, 'order_type' => 1, 'com_code' => $com_code));
$dataUpdateParent['total_cost_items'] = $total_detials_sum;
$dataUpdateParent['total_befor_discount'] = $total_detials_sum + $parent_pill_data['tax_value'];
$dataUpdateParent['total_cost'] = $dataUpdateParent['total_befor_discount'] - $parent_pill_data['discount_value'];
$dataUpdateParent['updated_by'] = auth()->user()->id;
$dataUpdateParent['updated_at'] = date("Y-m-d H:i:s");
update(new inv_production_receive(), $dataUpdateParent, array("auto_serial" => $request->autoserailparent, "com_code" => $com_code, 'order_type' => 1));
echo json_encode("done");
}
}
}
}

}




}