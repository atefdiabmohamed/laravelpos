<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales_invoices;
use App\Models\Admin;
use App\Models\Sales_matrial_types;
use App\Models\Customer;
use App\Models\Inv_itemCard;
use App\Models\Inv_itemcard_batches;
use App\Models\Inv_uom;
use App\Models\Store;

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
  $item_cards=get_cols_where(new Inv_itemCard(),array("item_code","name","item_type"),array("com_code"=>$com_code,"active"=>1));
  $stores=get_cols_where(new Store(),array("id","name"),array("com_code"=>$com_code,"active"=>1),'id','ASC');

  return view("admin.sales_invoices.loadModalAddInvoice",['item_cards'=>$item_cards,'stores'=>$stores]);  

}
}
public function get_item_batches(Request $request)
{
  $com_code = auth()->user()->com_code;

 if ($request->ajax()) {
  $item_card_Data=get_cols_where_row(new Inv_itemCard(),array("item_type","uom_id","retail_uom_quntToParent"),array("com_code"=>$com_code,"item_code"=>$request->item_code));
  if(!empty( $item_card_Data)){
    $requesed['uom_id']=$request->uom_id;
    $requesed['store_id']=$request->store_id;
    $requesed['item_code']=$request->item_code;
    $parent_uom=$item_card_Data['uom_id'];
    $uom_Data=get_cols_where_row(new Inv_uom(),array("name","is_master"),array("com_code"=>$com_code,"id"=>$requesed['uom_id']));
 if(!empty($uom_Data)){
  //لو صنف مخزني يبقي ههتم بالتواريخ
 if($item_card_Data['item_type']==2){
 $inv_itemcard_batches=get_cols_where(new Inv_itemcard_batches(),array("unit_cost_price","quantity","production_date","expired_date","auto_serial"),
 array("com_code"=>$com_code,"store_id"=>$requesed['store_id'],"item_code"=>$requesed['item_code'],"inv_uoms_id"=>$parent_uom),'production_date','ASC');

}else{
    $inv_itemcard_batches=get_cols_where(new Inv_itemcard_batches(),array("unit_cost_price","quantity","auto_serial"),
    array("com_code"=>$com_code,"store_id"=>$requesed['store_id'],"item_code"=>$requesed['item_code'],"inv_uoms_id"=>$parent_uom),'id','ASC');
}


return view("admin.sales_invoices.get_item_batches",['item_card_Data'=>$item_card_Data,'requesed'=>$requesed,'uom_Data'=>$uom_Data,'inv_itemcard_batches'=>$inv_itemcard_batches]);  

 }


 
  }




}
}



}
