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
class Services_with_ordersController extends Controller
{
  
    public function index()
    {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new services_with_orders(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
    if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    $info->account_name = Account::where('account_number', $info->account_number)->value('name');
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

}
