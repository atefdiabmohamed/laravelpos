<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admins_Shifts;
use App\Models\Admin;
use App\Models\Treasuries;
use App\Models\Admins_treasuries;
use App\Models\Treasuries_transactions;
use App\Models\Admin_panel_setting;

use App\Http\Requests\AdminShiftsRequest;
use App\Models\Mov_type;
use App\Models\Treasuries_delivery;

class Admins_ShiftsContoller extends Controller
{
public function index()
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_p(new Admins_Shifts(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
$checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("id","treasuries_id"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0));

if (!empty($data)) {
foreach ($data as $info) {
$info->admin_name = Admin::where('id', $info->admin_id)->value('name');
$info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
if($info->is_finished==1 and $info->is_delivered_and_review==0  and !empty($checkExistsOpenShift)){
  $check_permission_treasuries_delivery=get_cols_where_row(new Treasuries_delivery(),array("id"),array("com_code"=>$com_code,"treasuries_id"=>$checkExistsOpenShift['treasuries_id'],"treasuries_can_delivery_id"=>$info->treasuries_id));
   if(!empty($check_permission_treasuries_delivery)){
      $info->can_review=true;
   }else{
      $info->can_review=false;   
   }
}


}
}


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


public function finish($shiftid){
    try{
    $com_code=auth()->user()->com_code;
    $admin_id=auth()->user()->id;
    //check if not exsits open shift to current user
    $checkExistsShift=get_cols_where_row(new Admins_Shifts(),array("id","shift_code"),array("com_code"=>$com_code,"admin_id"=>$admin_id,"is_finished"=>0,'id'=>$shiftid));
    if($checkExistsShift!=null and !empty($checkExistsOpenShift)){
    return redirect()->route('admin.admin_shift.index')->with(['error'=>' عفوا غير قادر علي الوصول الي بيانات الشفت']);
    }

    $data_update['money_should_deviled'] = get_sum_where(new Treasuries_transactions(), "money", array("com_code" => $com_code, "shift_code" => $checkExistsShift['shift_code']));
    $data_update['is_finished']=1;
    $data_update['end_date']=date("Y-m-d H:i:s");
    $data_update['updated_by']=auth()->user()->id;
    $data_update['updated_at']=date("Y-m-d H:i:s");
    $flag=update(new Admins_Shifts(),$data_update,array("com_code"=>$com_code,"admin_id"=>$admin_id,"is_finished"=>0,'id'=>$shiftid));
    if($flag){
    return redirect()->route('admin.admin_shift.index')->with(['success'=>'لقد تم اقفال الشفت  بنجاح']);
    }else{
    return redirect()->route('admin.admin_shift.index')->with(['error'=>'عفوا لقد حدث خطأ ما من فضلك حاول مرة اخري']);
    }
    }catch(\Exception $ex){
    return redirect()->back()
    ->with(['error'=>'عفوا حدث خطأ ما'.$ex->getMessage()])
    ->withInput();           
    }
    } 

    public function print_details($id){

        try {
        $com_code = auth()->user()->com_code;
        $Admins_Shifts = get_cols_where_row(new Admins_Shifts(), array("*"), array("id" => $id, "com_code" => $com_code));
        if (empty($Admins_Shifts)) {
        return redirect()->route('admin.admin_shift.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
        }
        $Admins_Shifts['admin_name'] = Admin::where('id', $Admins_Shifts['admin_id'])->value('name');
        $Admins_Shifts['treasuries_name'] = Treasuries::where('id', $Admins_Shifts['treasuries_id'])->value('name');
     if($Admins_Shifts['is_finished']==1 and $Admins_Shifts['is_delivered_and_review']){
        $Admins_Shifts['reviwed_by_admin_name'] = Admin::where('id', $Admins_Shifts['delivered_to_admin_id'])->value('name');
        $Admins_Shifts['reviwed_by_admin_treasuries'] = Treasuries::where('id', $Admins_Shifts['delivered_to_treasuries_id'])->value('name');
     
     }
     //تفاصيل حركة النقدية بهذا الشفت
        $treasuries_transactions = get_cols_where(new Treasuries_transactions(), array("*"), array('shift_code' => $Admins_Shifts['shift_code'],  'com_code' => $com_code), 'id', 'ASC');
        if (!empty($treasuries_transactions)) {
        foreach ($treasuries_transactions as $info) {
        $info->mov_type_name = Mov_type::where('id', $info->mov_type)->value('name');
        }
        }
        $systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
        $total_excahnge=Treasuries_transactions::where('com_code','=',$com_code)->where('shift_code','=',$Admins_Shifts['shift_code'])->where("money","<",0)->sum("money");
        $total_collect=Treasuries_transactions::where('com_code','=',$com_code)->where('shift_code','=',$Admins_Shifts['shift_code'])->where("money",">",0)->sum("money");
        $total_net=$total_excahnge+$total_collect;

        return view('admin.admins_shifts.print_details',['Admins_Shifts'=>$Admins_Shifts,'systemData'=>$systemData,'treasuries_transactions'=>$treasuries_transactions,'total_excahnge'=>$total_excahnge,'total_collect'=>$total_collect,'total_net'=>$total_net]);
       
        } catch (\Exception $ex) {
        return redirect()->back()
        ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
        }
        }

        function review_now(Request $request){
       if($request->ajax()){
         $com_code = auth()->user()->com_code;
         $admins_shifts_will_reviwed=get_cols_where_row(new Admins_Shifts(),array("*"),array("id"=>$request->id,"com_code"=>$com_code,"is_finished"=>1,"is_delivered_and_review"=>0));
         $checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("id","treasuries_id"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0));
         return view('admin.admins_shifts.review_now',['admins_shifts_will_reviwed'=>$admins_shifts_will_reviwed,'checkExistsOpenShift'=>$checkExistsOpenShift]);



      }

   }
      function do_review_now($shiftid,Request $request){
         
           $com_code = auth()->user()->com_code;
           $admins_shifts_will_reviwed=get_cols_where_row(new Admins_Shifts(),array("*"),array("id"=>$shiftid,"com_code"=>$com_code,"is_finished"=>1,"is_delivered_and_review"=>0));
           $checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("id","treasuries_id","shift_code"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0));
           if(empty($admins_shifts_will_reviwed)){
            return redirect()->route('admin.admin_shift.index')
            ->with(['error' => 'عفوا غير قادر علي الوصول الي بيانات هذا الشفت' ]);
           }
           if(empty($checkExistsOpenShift)){
            return redirect()->route('admin.admin_shift.index')
            ->with(['error' => 'عفوا انت لاتمتلك شفت مفتوح حاليا لتقوم بهذا الاجراء' ]);
           } 
  
       
//first get isal number with treasuries 
$treasury_date = get_cols_where_row(new Treasuries(), array("last_isal_collect"), array("com_code" => $com_code, "id" => $checkExistsOpenShift['treasuries_id']));
if (empty($treasury_date)) {
return redirect()->back()->with(['error' => "  عفوا بيانات الخزنة المختارة غير موجوده !!"])->withInput();
}
$last_record_treasuries_transactions_record = get_cols_where_row_orderby(new Treasuries_transactions(), array("auto_serial"), array("com_code" => $com_code), "auto_serial", "DESC");
if (!empty($last_record_treasuries_transactions_record)) {
$dataInsert['auto_serial'] = $last_record_treasuries_transactions_record['auto_serial'] + 1;
} else {
$dataInsert['auto_serial'] = 1;
}
$dataInsert['isal_number'] = $treasury_date['last_isal_collect'] + 1;
$dataInsert['shift_code'] = $checkExistsOpenShift['shift_code'];
//debit مدين
$dataInsert['money'] = $request->what_realy_delivered;
$dataInsert['treasuries_id'] =  $checkExistsOpenShift['treasuries_id'];
$dataInsert['mov_type'] = 1;
$dataInsert['move_date'] = date("Y-m-d");
$dataInsert['is_account'] = 0;
$dataInsert['is_approved'] = 1;
$treasuries_name_will_review = Treasuries::where('id', $admins_shifts_will_reviwed['treasuries_id'])->value('name');
$admin_name_will_review = Admin::where('id', $admins_shifts_will_reviwed['admin_id'])->value('name');

$dataInsert['byan'] = "مراجعة واستلام نقدية خزنة "." ".$treasuries_name_will_review." للمستخدم ".$admin_name_will_review."  شفت رقم ".$checkExistsOpenShift['shift_code'];
$dataInsert['created_at'] = date("Y-m-Y H:i:s");
$dataInsert['added_by'] = auth()->user()->id;
$dataInsert['com_code'] = $com_code;
$flag = insert(new Treasuries_transactions(), $dataInsert);
if($flag){
$Treasuries_transactionsData=get_cols_where_row(new Treasuries_transactions(),array("id"),$dataInsert);
   $dataToUpdate['is_delivered_and_review']=1;
   $dataToUpdate['delivered_to_admin_id']=$checkExistsOpenShift['admin_id'];
   $dataToUpdate['delivered_to_admin_sift_id']=$checkExistsOpenShift['shift_code'];
   $dataToUpdate['what_realy_delivered']=$request->what_realy_delivered;
   $dataToUpdate['money_state']=$request->money_state;
   $dataToUpdate['money_state_value']=$request->money_state_value;
   $dataToUpdate['review_receive_date'] = date("Y-m-d H:i:s");
  if(!empty($Treasuries_transactionsData)){
   $dataToUpdate['treasuries_transactions_id']=$Treasuries_transactionsData['id'];

  }
update(new Admins_Shifts(),$dataToUpdate,array("id"=>$shiftid,"com_code"=>$com_code,"is_finished"=>1,"is_delivered_and_review"=>0));

}
return redirect()->back()->with(['success' => " تم مراجعة استلام نقدية الشفت بنجاح"])->withInput();

        }

}
