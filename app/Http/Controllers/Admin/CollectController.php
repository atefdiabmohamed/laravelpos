<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Treasuries_transactions;
use App\Models\Admin;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Account;
use App\Models\Mov_type;
use App\Models\Account_types;

use App\Http\Requests\Collect_transactionRequest;

class CollectController extends Controller
{
    
    public function index()
  {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where2_p(new Treasuries_transactions(), array("*"), array("com_code" => $com_code),"money",">",0, 'id', 'DESC', PAGINATION_COUNT);
    if (!empty($data)) {
      foreach ($data as $info) {
        $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
        $info->treasuries_name = Treasuries::where('id', $info->treasuries_id)->value('name');
        $info->mov_type_name = Mov_type::where('id', $info->mov_type)->value('name');
        $info->account_type=Account::where(["account_number"=>$info->account_number,"com_code"=>$com_code])->value("account_type");
      $info->account_type_name=Account_types::where(["id"=>$info->account_type])->value("name");


      }
    }

    $checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("treasuries_id","shift_code"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0));
     if(!empty($checkExistsOpenShift)){
      $checkExistsOpenShift['treasuries_name'] = Treasuries::where('id', $checkExistsOpenShift['treasuries_id'])->value('name'); 
    //get Treasuries Balance
    $checkExistsOpenShift['treasuries_balance_now']=get_sum_where(new Treasuries_transactions(),"money",array("com_code"=>$com_code,"shift_code"=>$checkExistsOpenShift['shift_code']));
    
    
    }
    $mov_type=get_cols_where(new Mov_type(),array("id","name"),array("active"=>1,'in_screen'=>2,'is_private_internal'=>0),'id','ASC');
    $accounts=get_cols_where(new Account(),array("name","account_number","account_type"),array("com_code"=>$com_code,"is_archived"=>0,"is_parent"=>0),'id','DESC');
   if(!empty( $accounts)){
    foreach($accounts as $info){
      $info->account_type_name=Account_types::where(["id"=>$info->account_type])->value("name");

    }
   }
    return view('admin.collect_transactions.index', ['data' => $data,'checkExistsOpenShift'=>$checkExistsOpenShift,'accounts'=>$accounts,'mov_type'=>$mov_type]);
  }
  //for collect money
  public function store(Collect_transactionRequest $request){
     try{

     $com_code=auth()->user()->com_code; 
  //check if user has open shift or not
  $checkExistsOpenShift=get_cols_where_row(new Admins_Shifts(),array("treasuries_id","shift_code"),array("com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0,"treasuries_id"=>$request->treasuries_id));
if(empty($checkExistsOpenShift)){
  return redirect()->back()->with(['error'=>"  عفوا لايوجد شفت خزنة مفتوح حاليا !!"])->withInput();
 }

    //first get isal number with treasuries 
    $treasury_date=get_cols_where_row(new Treasuries(),array("last_isal_collect"),array("com_code"=>$com_code,"id"=>$request->treasuries_id));
    if(empty($treasury_date)){
      return redirect()->back()->with(['error'=>"  عفوا بيانات الخزنة المختارة غير موجوده !!"])->withInput();
    }

$last_record_treasuries_transactions_record=get_cols_where_row_orderby(new Treasuries_transactions(),array("auto_serial"),array("com_code"=>$com_code),"auto_serial","DESC");
if(!empty($last_record_treasuries_transactions_record)){
  $dataInsert['auto_serial']=$last_record_treasuries_transactions_record['auto_serial']+1;
}else{
  $dataInsert['auto_serial']=1;

}

$dataInsert['isal_number']=$treasury_date['last_isal_collect']+1;
$dataInsert['shift_code']=$checkExistsOpenShift['shift_code'];
//debit مدين
$dataInsert['money']=$request->money;
$dataInsert['treasuries_id']=$request->treasuries_id;
$dataInsert['mov_type']=$request->mov_type;
$dataInsert['move_date']=$request->move_date;
$dataInsert['account_number']=$request->account_number;
$dataInsert['is_account']=1;
$dataInsert['is_approved']=1;
//Credit دائن
$dataInsert['money_for_account']=$request->money*(-1);
$dataInsert['byan']=$request->byan;
$dataInsert['created_at']=date("Y-m-Y H:i:s");
$dataInsert['added_by']=auth()->user()->id;
$dataInsert['com_code']=$com_code;
$flag=insert(new Treasuries_transactions(),$dataInsert);
if($flag){
  //update Treasuries last_isal_collect
$dataUpdateTreasuries['last_isal_collect']=$dataInsert['isal_number'];
update(new Treasuries(),$dataUpdateTreasuries,array("com_code"=>$com_code,"id"=>$request->treasuries_id));
return redirect()->route('admin.collect_transaction.index')->with(['success'=>"لقد تم اضافة البيانات بنجاح "]);


}else{
  return redirect()->back()->with(['error'=>" عفوا حدث خطأ م من فضلك حاول مرة اخري !"])->withInput();

}




     }catch(\Exception $ex){
return redirect()->back()->with(['error'=>"عفوا حدث خطأما"." ".$ex->getMessage()])->withInput();


     }



  }




}
