<?php
//لاتنسونا من صالح الدعاء
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة

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

$allitemscardData=get_cols_where_p(new Inv_itemCard(),array("id","name","item_code","item_type","does_has_retailunit","retail_uom_id","uom_id","retail_uom_quntToParent","All_QUENTITY"),array("com_code"=>$com_code),"id","ASC",PAGINATION_COUNT);
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
$itemCardsSearch=get_cols_where(new Inv_itemCard(),array("item_code","name"),array("com_code"=>$com_code),'id','ASC');
$storesSearch=get_cols_where(new Store(),array("id","name"),array("com_code"=>$com_code),'id','ASC');
return view('admin.itemcardBalance.index',['allitemscardData'=>$allitemscardData,'inv_itemcard_categories'=>$inv_itemcard_categories,'itemCardsSearch'=>$itemCardsSearch,'storesSearch'=>$storesSearch]);
}
public function ajax_search(Request $request)
{
if ($request->ajax()) {
$com_code=auth()->user()->com_code;
$item_code = $request->item_code;
$store_id = $request->store_id;
$BatchStatus = $request->BatchStatus;
$BatchTypeSerach= $request->BatchTypeSerach;
$BatchquantitystatusSerach = $request->BatchquantitystatusSerach;
$BatchquantitySerach = $request->BatchquantitySerach;
if ($item_code == 'all') {
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "item_code";
$operator1 = "=";
$value1 = $item_code;
}
if ($store_id == 'all') {
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "store_id";
$operator2 = "=";
$value2 = $store_id;
}
if ($BatchStatus == 'all') {
$field3 = "id";
$operator3 = ">";
$value3 = 0;
} else {
if($BatchStatus==1){
$field3 = "quantity";
$operator3 = ">";
$value3 = 0;
}else{
$field3 = "quantity";
$operator3 = "=";
$value3 = 0;
}
}
if ($BatchTypeSerach == 'all') {
$field4 = "id";
$operator4 = ">";
$value4 = 0;
$allitemscardData = Inv_itemCard::select("id","name","item_code","item_type","does_has_retailunit","retail_uom_id","uom_id","retail_uom_quntToParent","All_QUENTITY")->where($field1, $operator1, $value1)->orderBy('id', 'ASC')->paginate(PAGINATION_COUNT);
}elseif ($BatchTypeSerach == 1) {
$field4 = "production_date";
$operator4 = "!=";
$value4 = null;
$allitemscardData = Inv_itemCard::select("id","name","item_code","item_type","does_has_retailunit","retail_uom_id","uom_id","retail_uom_quntToParent","All_QUENTITY")->where($field1, $operator1, $value1)->where('item_type','=',2)->orderBy('id', 'ASC')->paginate(PAGINATION_COUNT);
} 
else {
$field4 = "production_date";
$operator4 = "=";
$value4 = null;
$allitemscardData = Inv_itemCard::select("id","name","item_code","item_type","does_has_retailunit","retail_uom_id","uom_id","retail_uom_quntToParent","All_QUENTITY")->where($field1, $operator1, $value1)->where('item_type','!=',2)->orderBy('id', 'ASC')->paginate(PAGINATION_COUNT);
}
if ($BatchquantitystatusSerach == 'all') {
$field5 = "id";
$operator5 = ">";
$value5 = 0;
}elseif ($BatchquantitystatusSerach == 1) { 
$field5 = "quantity";
$operator5 = ">";
$value5 = $BatchquantitySerach;
}elseif ($BatchquantitystatusSerach == 2) { 
$field5 = "quantity";
$operator5 = "<";
$value5 = $BatchquantitySerach;
}else{
$field5 = "quantity";
$operator5 = "=";
$value5 = $BatchquantitySerach;
}
if (!empty($allitemscardData)) {
foreach ($allitemscardData as $info) {
$info->inv_itemcard_categories_name = get_field_value(new inv_itemcard_categorie(), 'name', array('id' => $info->inv_itemcard_categories_id));
$info->Uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->uom_id));
if($info->does_has_retailunit==1){
$info->retail_uom_name = get_field_value(new Inv_uom(), 'name', array('id' => $info->retail_uom_id));
}
$info->allQuantitySearch=Inv_itemcard_batches::where($field2,$operator2,$value2)->where($field3,$operator3,$value3)->where($field4,$operator4,$value4)->where($field5,$operator5,$value5)->sum('quantity');     
$info->allBathces=Inv_itemcard_batches::select("*")->where($field2,$operator2,$value2)->where($field3,$operator3,$value3)->where($field4,$operator4,$value4)->where($field5,$operator5,$value5)->orderBy('store_id','ASC')->orderBy('quantity','DESC')->get();
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
return view('admin.itemcardBalance.ajax_search', ['allitemscardData' => $allitemscardData]);
}
}
}