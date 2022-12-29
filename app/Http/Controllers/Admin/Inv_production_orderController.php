<?php
//لاتنسونا من صالح الدعاء
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Inv_production_order;
use App\Http\Requests\inv_production_orderRequest;
use App\Models\Inv_stores_inventory;

class Inv_production_orderController extends Controller
{
public function index(){
try{
$com_code=auth()->user()->com_code;
$data=get_cols_where_p(new Inv_production_order(),array("*"),array("com_code"=>$com_code),'id','DESC',PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.inv_production_order.index',['data'=>$data]);
}catch(\Exception $ex){
return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما']);
}
}
public function create(){
return view('admin.inv_production_order.create');
}
public function store(inv_production_orderRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$row = get_cols_where_row_orderby(new Inv_production_order(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data['auto_serial'] = 1;
}
$data['production_plane'] = $request->production_plane;
$data['production_plan_date'] = $request->production_plan_date;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
insert(new Inv_production_order(),$data);
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed'] == 1) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
return view('admin.inv_production_order.edit', ['data' => $data]);


}

public function update($id, inv_production_orderRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if($data['is_closed'] == 1) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}

$data_to_update['production_plan_date'] = $request->production_plan_date;
$data_to_update['production_plane'] = $request->production_plane;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new Inv_production_order(), $data_to_update, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.inv_production_order.index', $id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$data = get_cols_where_row(new Inv_production_order(), array("is_closed"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($data['is_closed'] == 1) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن حذف  أمر  تشغيل معتمد ومؤرشف ']);
}
//هنا حنعمل مستقبلا  التشيك علي عدم استخدامه في اوامر الصرف الداخلية من مخازن الخامات للورش

$flag = delete(new Inv_production_order(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function show_more_detials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new  Inv_production_order(), array("*"), array("id" => $request->id, "com_code" => $com_code));
if (!empty($data)) {
if($data['updated_by']>0)
{
    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}

}
return view('admin.inv_production_order.show_more_detials', ['data' => $data]);

}
}

}