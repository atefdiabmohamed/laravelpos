<?php
use App\Models\Permission_roles_main_menus;
use App\Models\Permission_roles_sub_menu;
use App\Models\Permission_roles_sub_menues_actions;
use App\Models\Admin;


function check_permission_main_menue($permission_main_menues_id=null){
if($permission_main_menues_id=="" || $permission_main_menues_id==null){
    return false;
}else{
$permission_roles_id=auth()->user()->permission_roles_id;
$data=Permission_roles_main_menus::select("id")->where(['permission_roles_id'=>$permission_roles_id,'permission_main_menues_id'=>$permission_main_menues_id])->first();
if(!empty($data)){
    return true;
}else{
    return false;   
}


}

}

function check_permission_sub_menue($permission_sub_menues_id=null){
    if($permission_sub_menues_id=="" || $permission_sub_menues_id==null){
        return false;
    }else{
    $permission_roles_id=auth()->user()->permission_roles_id;
    $data=Permission_roles_sub_menu::select("id")->where(['permission_roles_id'=>$permission_roles_id,'permission_sub_menues_id'=>$permission_sub_menues_id])->first();
    if(!empty($data)){
        return true;
    }else{
        return false;   
    }
    
    
    }
    
    }


    function check_permission_sub_menue_actions($permission_roles_sub_menues_actions=null){
        if($permission_roles_sub_menues_actions=="" || $permission_roles_sub_menues_actions==null){
            return false;
        }else{
        $permission_roles_id=auth()->user()->permission_roles_id;
        $data=Permission_roles_sub_menues_actions::select("id")->where(['permission_roles_id'=>$permission_roles_id,'permission_sub_menues_actions_id'=>$permission_roles_sub_menues_actions])->first();
        if(!empty($data)){
            return true;
        }else{
            return false;   
        }
        
        
        }
        
        }


        function check_permission_sub_menue_actions_redirect($permission_roles_sub_menues_actions=null){
            if($permission_roles_sub_menues_actions=="" || $permission_roles_sub_menues_actions==null){
                return false;
            }else{
            $permission_roles_id=auth()->user()->permission_roles_id;
            $data=Permission_roles_sub_menues_actions::select("id")->where(['permission_roles_id'=>$permission_roles_id,'permission_sub_menues_actions_id'=>$permission_roles_sub_menues_actions])->first();
            if(empty($data)){
        return redirect()->away(route('admin.dashboard'))->send()->with(['error'=>'عفوا لاتمتلك صلاحيات لهذه الصفحة']);;
           
            }
            
            
            }
            
            }     


function uploadImage($folder, $image)
{
$extension = strtolower($image->extension());
$filename = time() . rand(100, 999) . '.' . $extension;
$image->getClientOriginalName = $filename;
$image->move($folder, $filename);
return $filename;
}
//we set default value for each parameter in function to avoid error in composer update
//Deprecate required parameters after optional parameters in
/*get some cols by pagination table */
function get_cols_where_p($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC",$pagination_counter=13)
{
$data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->paginate($pagination_counter);
return $data;
}
/*get some cols by pagination table where 2 */
function get_cols_where2_p($model=null, $columns_names = array(), $where = array(),$where2field=null,$where2operator=null,$where2value=null, $order_field="id",$order_type="DESC",$pagination_counter=13)
{
$data = $model::select($columns_names)->where($where)->where($where2field,$where2operator,$where2value)->
orderby($order_field, $order_type)->paginate($pagination_counter);
return $data;
}
/*get some cols  table */
function get_cols_where($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC")
{
$data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->get();
return $data;
}
/*get some cols  table */
function get_cols_where_limit($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC",$limit=1)
{
$data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->limit($limit)->get();
return $data;
}
/*get some cols  table 2 */
function get_cols_where_order2($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC",$order_field2="id",$order_type2="DESC")
{
$data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->orderby($order_field2, $order_type2)->get();
return $data;
}
/*get some cols  table */
function get_cols($model=null, $columns_names = array(), $order_field="id",$order_type="DESC")
{
$data = $model::select($columns_names)->orderby($order_field, $order_type)->get();
return $data;
}
/*get some cols row table */
function get_cols_where_row($model=null, $columns_names = array(), $where = array())
{
$data = $model::select($columns_names)->where($where)->first();
return $data;
}
/*get some cols row table */
function get_cols_where2_row($model=null, $columns_names = array(), $where = array(),$where2 = "")
{
$data = $model::select($columns_names)->where($where)->where($where2)->first();
return $data;
}
/*get some cols row table order by */
function get_cols_where_row_orderby($model, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC")
{
$data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->first();
return $data;
}
/*get some cols table */
function insert($model=null, $arrayToInsert=array(),$returnData=false)
{
$flag = $model::create($arrayToInsert);
if($returnData==true){
$data=get_cols_where_row($model,array("*"),$arrayToInsert);
return $data;
}else{
return $flag;
}
}
function get_field_value($model=null, $field_name=null , $where = array())
{
$data = $model::where($where)->value($field_name);
return $data;
}
function update($model=null,$data_to_update=array(),$where=array()){
$flag=$model::where($where)->update($data_to_update);
return $flag;
}
function delete($model=null,$where=array()){
$flag=$model::where($where)->delete();
return $flag;
}
function get_sum_where($model=null,$field_name=null,$where=array()){
$sum=$model::where($where)->sum($field_name);
return $sum;
}
function get_user_shift($Admins_Shifts,$Treasuries=null,$Treasuries_transactions=null){
$com_code=auth()->user()->com_code;
$data = $Admins_Shifts::select("treasuries_id","shift_code")->where(["com_code"=>$com_code,"admin_id"=>auth()->user()->id,"is_finished"=>0])->first();
if(!empty($data)){
$data['name']=$Treasuries::where(["id"=>$data["treasuries_id"],"com_code"=>$com_code])->value("name");
$data['balance']=$Treasuries_transactions::where(["shift_code"=>$data["shift_code"],"com_code"=>$com_code])->sum("money");
}
return $data;
}
//get Account Balance دالة احتساب وتحديث رصيد الحساب المالي للمورد  
function refresh_account_blance_supplier($account_number=null,$AccountModel=null,$SupplierModel=null,$treasuries_transactionsModel=null,$suppliers_with_ordersModel=null,$ServicesOrdersModel=null,$returnFlag=false){
$com_code=auth()->user()->com_code;
//حنجيب الرصيد الافتتاحي  للحساب اول المده لحظة تكويده
$AccountData=  $AccountModel::select("start_balance","account_type")->where(["com_code"=>$com_code,"account_number"=>$account_number])->first();
//لو مورد
if($AccountData['account_type']==2){
//صافي مجموع المشتريات والمرتجعات للمورد   
$the_net_in_suppliers_with_orders=$suppliers_with_ordersModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//صافي حركة النقديه بالخزن علي حساب المورد
$the_net_in_treasuries_transactions=$treasuries_transactionsModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//صافي حركة فواتير الخدمات الخارجية والداخلية المتعلقه بالحساب المالي للمورد
$the_net_in_services_orders=$ServicesOrdersModel::where(["com_code"=>$com_code,"account_number"=>$account_number,'is_account_number'=>1])->sum("money_for_account");
//الرصيد النهائي للمورد
$the_final_Balance=$AccountData['start_balance']+$the_net_in_suppliers_with_orders+$the_net_in_treasuries_transactions+$the_net_in_services_orders;
$dataToUpdateAccount['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول الحسابات المالية بحقل المورد
$AccountModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateAccount);
$dataToUpdateSupplier['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول الموردين  بحقل المورد
$SupplierModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateSupplier);
if($returnFlag){
return $the_final_Balance;
}
}
}
function refresh_account_blance_delegate($account_number=null,$AccountModel=null,$delgateModel=null,$treasuries_transactionsModel=null,$SalesinvoiceModel=null,$ServicesOrdersModel=null,$returnFlag=true){
$com_code=auth()->user()->com_code;
//حنجيب الرصيد الافتتاحي  للحساب اول المده لحظة تكويده
$AccountData=  $AccountModel::select("start_balance","account_type","other_table_FK")->where(["com_code"=>$com_code,"account_number"=>$account_number])->first();
//لو مندوب
if(!empty($AccountData)){
if($AccountData['account_type']==4){
//صافي مجموع عموله المندوب بالمبيعات 
$the_net_sales_invoicesForDelegate=$SalesinvoiceModel::where(["com_code"=>$com_code,"delegate_code"=>$AccountData['other_table_FK']])->sum("delegate_commission_value");
//صافي حركة النقديه بالخزن علي حساب المندوب
$the_net_in_treasuries_transactions=$treasuries_transactionsModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//الرصيد النهائي المندوب
//حساب اول المده +صافي المبيعات والمرتجعات +صافي حركة النقدية بالخزن للحساب المالي المندوب الحالي
//صافي حركة فواتير الخدمات الخارجية والداخلية المتعلقه بالحساب المالي للمندوب
$the_net_in_services_orders=$ServicesOrdersModel::where(["com_code"=>$com_code,"account_number"=>$account_number,'is_account_number'=>1])->sum("money_for_account");
$the_final_Balance=$AccountData['start_balance']+$the_net_sales_invoicesForDelegate+$the_net_in_treasuries_transactions+$the_net_in_services_orders;
$dataToUpdateAccount['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول الحسابات المالية بحقل المندوب
$AccountModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateAccount);
$dataToUpdateDelgate['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول   بحقل المندوب
$delgateModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateDelgate);
if($returnFlag){
return $the_final_Balance;
}
}
}
}
//get Account Balance دالة احتساب وتحديث رصيد الحساب المالي للعميل  
function refresh_account_blance_customer($account_number=null,$AccountModel=null,$customerModel=null,$treasuries_transactionsModel=null,$SalesinvoiceModel=null,$SalesReturnModel=null,$ServicesOrdersModel=null,$returnFlag=false){
$com_code=auth()->user()->com_code;
//حنجيب الرصيد الافتتاحي  للحساب اول المده لحظة تكويده
$AccountData=  $AccountModel::select("start_balance","account_type")->where(["com_code"=>$com_code,"account_number"=>$account_number])->first();
//لو عميل
if($AccountData['account_type']==3){
//صافي مجموع المبيعات والمرتجعات للمورد   
$the_net_sales_invoicesForCustomer=$SalesinvoiceModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//    صافي  مرتجع المبيعات بس لما نعمله
$the_net_sales_invoicesReturnForCustomer=$SalesReturnModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//صافي حركة النقديه بالخزن علي حساب العميل
$the_net_in_treasuries_transactions=$treasuries_transactionsModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//الرصيد النهائي للعميل
//حساب اول المده +صافي المبيعات والمرتجعات +صافي حركة النقدية بالخزن للحساب المالي للعميل الحالي
//صافي حركة فواتير الخدمات الخارجية والداخلية المتعلقه بالحساب المالي للعميل
$the_net_in_services_orders=$ServicesOrdersModel::where(["com_code"=>$com_code,"account_number"=>$account_number,'is_account_number'=>1])->sum("money_for_account");
$the_final_Balance=$AccountData['start_balance']+$the_net_sales_invoicesForCustomer+$the_net_sales_invoicesReturnForCustomer+$the_net_in_treasuries_transactions+$the_net_in_services_orders;
$dataToUpdateAccount['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول الحسابات المالية بحقل العميل
$AccountModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateAccount);
$dataToUpdateSupplier['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول العملاء  بحقل العميل
$customerModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateSupplier);
if($returnFlag){
return $the_final_Balance;
}
}
}
//get Account Balance دالة احتساب وتحديث رصيد الحساب المالي العام  
function refresh_account_blance_General($account_number=null,$AccountModel=null,$treasuries_transactionsModel=null,$ServicesOrdersModel=null,$returnFlag=false){
$com_code=auth()->user()->com_code;
//حنجيب الرصيد الافتتاحي  للحساب اول المده لحظة تكويده
$AccountData=  $AccountModel::select("start_balance","account_type")->where(["com_code"=>$com_code,"account_number"=>$account_number])->first();
//لو عميل
if($AccountData['account_type']!=2 and $AccountData['account_type']!=3 and $AccountData['account_type']!=4 and $AccountData['account_type']!=5 and $AccountData['account_type']!=8){
//صافي حركة النقديه بالخزن علي حساب العميل
$the_net_in_treasuries_transactions=$treasuries_transactionsModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//صافي حركة فواتير الخدمات الخارجية والداخلية المتعلقه بالحساب المالي 
$the_net_in_services_orders=$ServicesOrdersModel::where(["com_code"=>$com_code,"account_number"=>$account_number,'is_account_number'=>1])->sum("money_for_account");
$the_final_Balance=$AccountData['start_balance']+$the_net_in_treasuries_transactions+$the_net_in_services_orders;
$dataToUpdateAccount['current_balance']=$the_final_Balance;
$AccountModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateAccount);
if($returnFlag){
return $the_final_Balance;
}
}
}
function do_update_itemCardQuantity($Inv_itemCard=null,$item_code=null,$Inv_itemcard_batches=null,$does_has_retailunit=null,$retail_uom_quntToParent=null){
$com_code=auth()->user()->com_code;
// update itemcard Quantity mirror  تحديث المرآه الرئيسية للصنف
//حنجيب كمية الصنف من جدول الباتشات
$allQuantityINBatches=  $sum=$Inv_itemcard_batches::where(["com_code"=>$com_code,"item_code"=>$item_code])->sum("quantity");
//كل كمية الصنف بوحده الاب مباشره بدون اي تحويلات مثال  4شكارة وعلبتين
$DataToUpdateItemCardQuantity['All_QUENTITY']=$allQuantityINBatches;
if($does_has_retailunit==1){
//all quantity in reatails  كل الكمية بوحده التجزئة
//emaple 21 kilo
$QUENTITY_all_Retails=$allQuantityINBatches*$retail_uom_quntToParent;
// 21kilo  21/10  -> int 2 شكارة
$parentQuanityUom=intdiv($QUENTITY_all_Retails,$retail_uom_quntToParent);    
$DataToUpdateItemCardQuantity['QUENTITY']=$parentQuanityUom;
//% modelus  21%10  - 1 علبة 
$DataToUpdateItemCardQuantity['QUENTITY_Retail']=fmod($QUENTITY_all_Retails,$retail_uom_quntToParent);   
$DataToUpdateItemCardQuantity['QUENTITY_all_Retails']=$QUENTITY_all_Retails;
}else{
$DataToUpdateItemCardQuantity['QUENTITY']=$allQuantityINBatches;
}
update($Inv_itemCard,$DataToUpdateItemCardQuantity,array("com_code"=>$com_code,"item_code"=>$item_code));
}
/*get counter where from  table */
function get_count_where($model=null,  $where = array())
{
$counter = $model::where($where)->count();
return $counter;
}
//get Account Balance دالة احتساب وتحديث رصيد الحساب المالي للمورد  
function refresh_account_blance_ProductionLine($account_number=null,$AccountModel=null,$ProductionLineModel=null,$treasuries_transactionsModel=null,$ServicesOrdersModel=null,$inv_production_exchangeModel=null,$inv_production_receiveModel=null,$returnFlag=false){
$com_code=auth()->user()->com_code;
//حنجيب الرصيد الافتتاحي  للحساب اول المده لحظة تكويده
$AccountData=  $AccountModel::select("start_balance","account_type")->where(["com_code"=>$com_code,"account_number"=>$account_number])->first();
// 
if($AccountData['account_type']==5){
//صافي مجموع صرف الخامات واستلام الانتاج التام لخط الانتاج   
$the_net_in_inv_production_exchange=$inv_production_exchangeModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
$the_net_inv_production_receive=$inv_production_receiveModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
//صافي حركة النقديه بالخزن علي حساب خط الانتاج
$the_net_in_treasuries_transactions=$treasuries_transactionsModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->sum("money_for_account");
// صافي حركة فواتير الخدمات الخارجية والداخلية المتعلقه بالحساب المالي لخط الانتاج
$the_net_Services_inv_productionLine=$ServicesOrdersModel::where(["com_code"=>$com_code,"account_number"=>$account_number,'is_account_number'=>1])->sum("money_for_account");
// الرصيد النهائي لخط الانتاج
$the_final_Balance=$AccountData['start_balance']+$the_net_in_inv_production_exchange+$the_net_inv_production_receive+$the_net_Services_inv_productionLine+$the_net_in_treasuries_transactions;
$dataToUpdateAccount['current_balance']=$the_final_Balance;
// update in Accounts حندث جدول الحسابات المالية بحقل خط الانتاج
$AccountModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateAccount);
$dataToUpdateLine['current_balance']=$the_final_Balance;
//update in Accounts حندث جدول الموردين  بحقل المورد
$ProductionLineModel::where(["com_code"=>$com_code,"account_number"=>$account_number])->update($dataToUpdateLine);
if($returnFlag){
return $the_final_Balance;
}
}
}