<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales_invoices;
use App\Models\Admin;
use App\Models\Sales_matrial_types;
use App\Models\Customer;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;



class SalesInvoicesController extends Controller
{
    
public function index(){

 $com_code=auth()->user()->com_code;   
$data=get_cols_where_p(new Sales_invoices(),array("*"),array("com_code"=>$com_code),"id","DESC",PAGINATION_COUNT);
if(!empty($data)){
    foreach ($data as $info) {
        $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
        $info->Sales_matrial_types_name=get_field_value(new Sales_matrial_types(),"name",array("com_code"=>$com_code,"id"=>$info->sales_matrial_types)); 
       if($info->is_has_customer==1){
        $info->customer_name=get_field_value(new Customer(),"name",array("com_code"=>$com_code,"customer_code"=>$info->customer_code)); 
       }else{
        $info->customer_name="بدون عميل" ;
       }

    }


    
  return view("admin.sales_invoices.index",['data'=>$data]);  
}


}

public function get_item_uoms(Request $request)
{
    if ($request->ajax()) {
        $com_code = auth()->user()->com_code;
        $item_code = $request->item_code;
        $item_card_Data = get_cols_where_row(new Inv_itemCard(), array("does_has_retailunit", "retail_uom_id", "uom_id"), array("item_code" => $item_code, "com_code" => $com_code));
        if (!empty($item_card_Data)) {
            if ($item_card_Data['does_has_retailunit'] == 1) {
                $item_card_Data['parent_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['uom_id']));
                $item_card_Data['retial_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['retail_uom_id']));
            } else {
                $item_card_Data['parent_uom_name'] = get_field_value(new Inv_uom(), "name", array("id" => $item_card_Data['uom_id']));
            }
        }

        return view("admin.sales_invoices.get_item_uoms", ['item_card_Data' => $item_card_Data]);
    }
}

public function load_modal_add(Request $request)
{
  $com_code = auth()->user()->com_code;

 if ($request->ajax()) {
  $item_cards=get_cols_where(new Inv_itemCard(),array("item_code","name"),array("com_code"=>$com_code,"active"=>1));
  return view("admin.sales_invoices.loadModalAddInvoice",['item_cards'=>$item_cards]);  

}
}

}
