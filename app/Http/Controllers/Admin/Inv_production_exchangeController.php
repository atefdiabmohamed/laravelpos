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
}