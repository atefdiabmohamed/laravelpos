<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins_Shifts;
use App\Models\Admin;
use App\Models\Treasuries;
use App\Models\Admins_treasuries;
use App\Http\Requests\AdminShiftsRequest;
class Admins_ShiftsContoller extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Admins_Shifts(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->admin_name = Admin::where('id', $info->admin_id)->value('name');
$info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
}
}
$checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("id"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0));
return view('admin.admins_shifts.index', ['data' => $data,'checkExistsOpenShift'=>$checkExistsOpenShift]);
}
public function create()
{
$com_code = auth()->user()->com_code;    
$admins_treasuries=get_cols_where(new Admins_treasuries(),array('treasuries_id'),array('com_code'=>$com_code,'active'=>1,'admin_id'=>auth()->user()->id),'id','DESC');     
if (!empty($admins_treasuries)) {
foreach ($admins_treasuries as $info) {
$info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
$check_exsits_admins_shifts=get_cols_where_row(new Admins_Shifts(),array("id"),array("treasuries_id"=>$info->treasuries_id,'com_code'=>$com_code,'is_finished'=>0));
if(!empty($check_exsits_admins_shifts) and $check_exsits_admins_shifts!=null){
$info->avaliable=false;
}else{
$info->avaliable=true;
}
}
}
return view('admin.admins_shifts.create',['admins_treasuries'=>$admins_treasuries]);
}
public function store(AdminShiftsRequest $request){
try{
$com_code=auth()->user()->com_code;
$admin_id=auth()->user()->id;
//check if not exsits open shift to current user
$checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("id"),array("com_code"=>$com_code,"admin_id"=>$admin_id,"is_finished"=>0));
if($checkExistsOpenShift!=null and !empty($checkExistsOpenShift)){
return redirect()->route('admin.admin_shift.index')->with(['error'=>'عفوا هناك شفت مفتوح لديك بالفعل حاليا ولايمكن فتح شفت جديد الا بعد اغلاق الشفت الحالي']);
}
//check if not exsits open shift to current treasuries_id
$checkExistsOpentreasuries=get_cols_where_row(new Admins_Shifts(),array("id"),array("com_code"=>$com_code,"treasuries_id"=>$request->treasuries_id,"is_finished"=>0));
if($checkExistsOpentreasuries!=null and !empty($checkExistsOpentreasuries)){
return redirect()->route('admin.admin_shift.index')->with(['error'=>'  عفوا الخزنة المختاره بالفعل مستخدمه حاليا لدي شفت اخر ولايمكن استخدامها الا بعد انتهاء الشفت الاخر']);
}
//set Shift code
$row = get_cols_where_row_orderby(new Admins_Shifts(), array("shift_code"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data_insert['shift_code'] = $row['shift_code'] + 1;
} else {
$data_insert['shift_code'] = 1;
}
$data_insert['admin_id']=$admin_id;
$data_insert['treasuries_id']=$request->treasuries_id;
$data_insert['start_date']=date("Y-m-d H:i:s");
$data_insert['created_at']=date("Y-m-d H:i:s");
$data_insert['added_by']=auth()->user()->id;
$data_insert['com_code']=$com_code;
$data_insert['date']=date("Y-m-d");
$flag=insert(new Admins_Shifts(),$data_insert);
if($flag){
return redirect()->route('admin.admin_shift.index')->with(['success'=>'لقد تم اضافة البيانات بنجاح']);
}else{
return redirect()->route('admin.admin_shift.index')->with(['error'=>'عفوا لقد حدث خطأ ما من فضلك حاول مرة اخري']);
}
}catch(\Exception $ex){
return redirect()->back()
->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
->withInput();           
}
} 
}