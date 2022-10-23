<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\inv_itemcard_categorie;
use App\Models\Inv_itemcard_batches;
use App\Models\Store;

class ItemcardBalanceController extends Controller
{
public function index(){
//get all itemscars ordery by quantity
$com_code=auth()->user()->com_code;
$allitemscardData=get_cols_where_p(new Inv_itemCard(),array("id","name","item_code","item_type","does_has_retailunit","retail_uom_id","uom_id","retail_uom_quntToParent"),array("com_code"=>$com_code),"All_QUENTITY","DESC",PAGINATION_COUNT);
if (!empty($allitemscardData)) {
    foreach ($allitemscardData as $info) {
        $info->inv_itemcard_categories_name = get_field_value(new inv_itemcard_categorie(), 'name', array('id' => $info->inv_itemcard_categories_id));
        $info->Uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->uom_id));
        if($info->does_has_retailunit==1){
            $info->retail_uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->retail_uom_id));
        }

$info->allBathces=get_cols_where_order2(new Inv_itemcard_batches(),array("*"),array("com_code"=>$com_code,"item_code"=>$info->item_code),'store_id','ASC','quantity','DESC');
if(!empty($info->allBathces)){
    foreach($info->allBathces as $Det){
    $Det->store_name=get_field_value(new Store(),"name",array("com_code"=>$com_code,"id"=>$Det->store_id));  
      if($info->does_has_retailunit==1){
        $Det->qunatityRetail=$Det->quantity*$info->retail_uom_quntToParent;
        $Det->priceRetail=$Det->unit_cost_price/$info->retail_uom_quntToParent;
        
      }  

    }
}


        }
    }
    $inv_itemcard_categories = get_cols_where(new inv_itemcard_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    return view('admin.itemcardBalance.index',['allitemscardData'=>$allitemscardData,'inv_itemcard_categories'=>$inv_itemcard_categories]);
}



}
