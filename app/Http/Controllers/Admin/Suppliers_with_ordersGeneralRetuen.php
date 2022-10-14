<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Suppliers_with_orders;
use App\Models\Suppliers_with_orders_details;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Store;
use App\Models\Admins_Shifts;
use App\Models\Treasuries;
use App\Models\Treasuries_transactions;
use App\Models\Inv_itemcard_movements;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Inv_itemcard_batches;
use App\Http\Requests\Suppliers_orders_general_returnRequest;
class Suppliers_with_ordersGeneralRetuen extends Controller
{
    
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new Suppliers_with_orders(), array("*"), array("com_code" => $com_code,'order_type'=>3), 'id', 'DESC', PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                $info->supplier_name = Supplier::where('suuplier_code', $info->suuplier_code)->value('name');
                $info->store_name = Store::where('id', $info->store_id)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }

        $suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code), 'id', 'DESC');
        $stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');


        return view('admin.suppliers_orders_general_return.index', ['data' => $data, 'suupliers' => $suupliers, 'stores' => $stores]);
    }


    public function create()
    {
        $com_code = auth()->user()->com_code;
        $suupliers = get_cols_where(new Supplier(), array('suuplier_code', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
        $stores = get_cols_where(new Store(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');

        return view('admin.suppliers_orders_general_return.create', ['suupliers' => $suupliers, 'stores' => $stores]);
    }

 
    public function store(Suppliers_orders_general_returnRequest $request)
    {

        try {

            $com_code = auth()->user()->com_code;
            $supplierData = get_cols_where_row(new Supplier(), array("account_number"), array("suuplier_code" => $request->suuplier_code, "com_code" => $com_code));
            if (empty($supplierData)) {
                return redirect()->back()
                    ->with(['error' => 'عفوا   غير قادر علي الوصول الي بيانات المورد المحدد'])
                    ->withInput();
            }


            $row = get_cols_where_row_orderby(new Suppliers_with_orders(), array("auto_serial"), array("com_code" => $com_code,'order_type'=>3), 'id', 'DESC');
            if (!empty($row)) {
                $data_insert['auto_serial'] = $row['auto_serial'] + 1;
            } else {
                $data_insert['auto_serial'] = 1;
            }

            $data_insert['order_date'] = $request->order_date;
            $data_insert['order_type'] = 3;
            $data_insert['suuplier_code'] = $request->suuplier_code;
            $data_insert['pill_type'] = $request->pill_type;
            $data_insert['store_id'] = $request->store_id;
            $data_insert['account_number'] = $supplierData['account_number'];
            $data_insert['added_by'] = auth()->user()->id;
            $data_insert['created_at'] = date("Y-m-d H:i:s");
            $data_insert['date'] = date("Y-m-d");
            $data_insert['com_code'] = $com_code;
          insert(new Suppliers_with_orders(),$data_insert);
            $id = get_field_value(new Suppliers_with_orders(), "id", array("auto_serial" => $data_insert['auto_serial'], "com_code" => $com_code, "order_type" => 3));

            return redirect()->route("admin.suppliers_orders_general_return.index")->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
        } catch (\Exception $ex) {

            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }


}
