<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\inv_itemcard_categorie;
use App\Models\Inv_itemcard_batches;


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
        }
    }
    $inv_itemcard_categories = get_cols_where(new inv_itemcard_categorie(), array('id', 'name'), array('com_code' => $com_code, 'active' => 1), 'id', 'DESC');
    return view('admin.itemcardBalance.index',['allitemscardData'=>$allitemscardData,'inv_itemcard_categories'=>$inv_itemcard_categories]);
}



}
