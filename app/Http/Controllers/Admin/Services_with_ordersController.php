<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Account;
use App\Models\Services;
use App\Models\services_with_orders;
use App\Models\services_with_orders_details;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Http\Requests\Services_orders_request;
class Services_with_ordersController extends Controller
{
  
    public function index()
    {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new services_with_orders(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
    if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->is_account_number==1){
    $info->account_name = Account::where('account_number', $info->account_number)->value('name');
    }
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }
    $accounts = get_cols_where(new Account(), array('account_number', 'name'), array('com_code' => $com_code,'is_parent'=>0), 'id', 'DESC');
    return view('admin.services_with_orders.index', ['data' => $data, 'accounts' => $accounts]);
   
}
public function create()
{
$com_code = auth()->user()->com_code;
$accounts = get_cols_where(new Account(), array('account_number', 'name'), array('com_code' => $com_code,'is_parent'=>0), 'id', 'DESC');
return view('admin.services_with_orders.create', ['accounts' => $accounts]);
}

public function store(Services_orders_request $request)
{
try {
$com_code = auth()->user()->com_code;
if($request->is_account_number==1){

$AccountData = get_cols_where_row(new Account(), array("id"), array("account_number" => $request->account_number, "com_code" => $com_code));
if (empty($AccountData)) {
return redirect()->back()
->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات الحساب المحدد'])
->withInput();
}

}
if($request->order_type==1){
    $row = get_cols_where_row_orderby(new services_with_orders(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>1), 'id', 'DESC');
}else{
    $row = get_cols_where_row_orderby(new services_with_orders(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>2), 'id', 'DESC');

}


if (!empty($row)) {
$data_insert['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data_insert['auto_serial'] = 1;
}
$data_insert['order_date'] = $request->order_date;
$data_insert['is_account_number'] = $request->is_account_number;
$data_insert['order_type'] = $request->order_type;
if($request->is_account_number==1){
    $data_insert['account_number'] = $request->account_number;
}else{
    $data_insert['entity_name'] = $request->entity_name;

}
$data_insert['pill_type'] = $request->pill_type;
$data_insert['added_by'] = auth()->user()->id;
$data_insert['created_at'] = date("Y-m-d H:i:s");
$data_insert['date'] = date("Y-m-d");
$data_insert['com_code'] = $com_code;
insert(new services_with_orders(),$data_insert);
$id = get_field_value(new services_with_orders(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => $request->order_type));
return redirect()->route("admin.Services_orders.index", $id)->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}




}
