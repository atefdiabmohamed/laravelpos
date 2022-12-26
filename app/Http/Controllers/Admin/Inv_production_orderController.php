<?php
//لاتنسونا من صالح الدعاء
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Inv_production_order;
use App\Http\Requests\inv_production_orderRequest;
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
}