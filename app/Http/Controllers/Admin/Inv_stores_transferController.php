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
}
