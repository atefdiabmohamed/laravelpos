<?php 
//لاتنسونا من صالح الدعاء
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Delegate;
use App\Models\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Suppliers_with_orders;
use App\Models\Suppliers_with_orders_details;
use App\Models\Treasuries_transactions;
use App\Models\Sales_invoices;
use App\Models\Sales_invoices_details;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetails;
use App\Models\Inv_itemCard;
use App\Models\Inv_uom;
use App\Models\Mov_type;
use App\Models\services_with_orders;
use App\Models\Services;
use App\Models\services_with_orders_details;
use Illuminate\Http\Request;
class FinancialReportController extends Controller
{
public function index(){
//تقارير احصائية 
}
public function supplier_account_mirror(Request $request){
if($_POST){
$com_code=auth()->user()->com_code;
$supplierData=get_cols_where_row(new Supplier(),array("account_number","start_balance","name","phones","date","suuplier_code"),array("com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code));
if(empty($supplierData)){
return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي بيانات هذا المورد !!']);
}
//General Report
if($request->report_type==1){
$supplierData['the_final_Balance']=refresh_account_blance_supplier($supplierData['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,true);
$supplierData['BurchaseCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->count();
$supplierData['BurchaseReturnCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->count();
$supplierData['BurchaseTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->sum('money_for_account');
$supplierData['BurchaseTotalMoney']= $supplierData['BurchaseTotalMoney']*(-1);
$supplierData['BurchaseReturnTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->sum('money_for_account');
$supplierData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->count();
$supplierData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->count();
$supplierData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->sum('money_for_account');
$supplierData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->sum('money_for_account');
$supplierData['ServicesForUsMoney']=$supplierData['ServicesForUsMoney']*(-1);
$supplierData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->sum('money_for_account');
$supplierData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->sum('money_for_account');
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
return view('admin.financialReport.print_supplier_account_mirror',['data'=>$supplierData,'systemData'=>$systemData]);
//تفصيلي
}elseif($request->report_type==2){
$supplierData['from_date']=$request->from_date;
$supplierData['to_date']=$request->to_date;
$supplierData['Does_show_items']=$request->Does_show_items;
$supplierData['the_final_Balance']=refresh_account_blance_supplier($supplierData['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,true);
$supplierData['BurchaseCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['BurchaseReturnCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['BurchaseTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['BurchaseTotalMoney']= $supplierData['BurchaseTotalMoney']*(-1);
$supplierData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['ServicesForUsMoney']=$supplierData['ServicesForUsMoney']*(-1);
$supplierData['BurchaseReturnTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->sum('money_for_account');
$details['Burchases']=Suppliers_with_orders::select('auto_serial','order_date','is_approved','total_cost','pill_type','what_paid','what_remain','order_type')->where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->get();
if($supplierData['Does_show_items']==1){
foreach( $details['Burchases'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Suppliers_with_orders_details(),array("*"),array("com_code"=>$com_code,"suppliers_with_orders_auto_serial"=>$Bur->auto_serial,'order_type'=>$Bur->order_type));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
// حرجعلها 
$details['BurchasesReturn']=Suppliers_with_orders::select('auto_serial','order_date','is_approved','total_cost','pill_type','what_paid','what_remain','order_type')->where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->where('order_type','>',1)->get();
if($supplierData['Does_show_items']==1){ 
foreach(  $details['BurchasesReturn'] as $return){  
$return->itemsdetails=get_cols_where(new Suppliers_with_orders_details(),array("*"),array("com_code"=>$com_code,"suppliers_with_orders_auto_serial"=>$return->auto_serial,'order_type'=>$return->order_type));
if(!empty($return->itemsdetails)){
foreach($return->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->where('account_number','=',$supplierData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
}
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$supplierData['account_number'] ])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($supplierData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
if($supplierData['Does_show_items']==1){
return view('admin.financialReport.print_supplier_account_mirrorIndetails_items',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
}else{
return view('admin.financialReport.print_supplier_account_mirrorIndetails',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
}
//المشتريات خلال الفترة
}elseif($request->report_type==3){
$supplierData['from_date']=$request->from_date;
$supplierData['to_date']=$request->to_date;
$supplierData['Does_show_items']=$request->Does_show_items;
$supplierData['the_final_Balance']=refresh_account_blance_supplier($supplierData['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,true);
$supplierData['BurchaseCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['BurchaseTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['BurchaseTotalMoney']= $supplierData['BurchaseTotalMoney']*(-1);
$details['Burchases']=Suppliers_with_orders::select('auto_serial','order_date','is_approved','total_cost','pill_type','what_paid','what_remain','order_type')->where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->get();
if($supplierData['Does_show_items']==1){
foreach( $details['Burchases'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Suppliers_with_orders_details(),array("*"),array("com_code"=>$com_code,"suppliers_with_orders_auto_serial"=>$Bur->auto_serial,'order_type'=>$Bur->order_type));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
return view('admin.financialReport.print_supplier_account_mirrorBurchases',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
//مرتجع مشتريات خلال الفترة
}elseif($request->report_type==4){
$supplierData['from_date']=$request->from_date;
$supplierData['to_date']=$request->to_date;
$supplierData['Does_show_items']=$request->Does_show_items;
$supplierData['the_final_Balance']=refresh_account_blance_supplier($supplierData['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,true);
$supplierData['BurchaseReturnCounter']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['BurchaseReturnTotalMoney']=Suppliers_with_orders::where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_type','>',1)->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$details['BurchasesReturn']=Suppliers_with_orders::select('auto_serial','order_date','is_approved','total_cost','pill_type','what_paid','what_remain','order_type')->where(["com_code"=>$com_code,'suuplier_code'=>$request->suuplier_code,'account_number'=>$supplierData['account_number']])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->where('order_type','>',1)->get();
if($supplierData['Does_show_items']==1){ 
foreach(  $details['BurchasesReturn'] as $return){  
$return->itemsdetails=get_cols_where(new Suppliers_with_orders_details(),array("*"),array("com_code"=>$com_code,"suppliers_with_orders_auto_serial"=>$return->auto_serial,'order_type'=>$return->order_type));
if(!empty($return->itemsdetails)){
foreach($return->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
} 
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
return view('admin.financialReport.print_supplier_account_mirrorBurchaseReturn',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
//حركة الخدمات خلال الفترة
}elseif($request->report_type==6){
$supplierData['from_date']=$request->from_date;
$supplierData['to_date']=$request->to_date;
$supplierData['Does_show_items']=$request->Does_show_items;
$supplierData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->count();
$supplierData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>1])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$supplierData['account_number'],'order_type'=>2])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['ServicesForUsMoney']=$supplierData['ServicesForUsMoney']*(-1);
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$supplierData['account_number'] ])->where('order_date','>=',$supplierData['from_date'])->where('order_date','<=',$supplierData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($supplierData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
return view('admin.financialReport.print_supplier_account_mirrorServices',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
}
//حركة النقدية خلال الفترة
else{
$supplierData['from_date']=$request->from_date;
$supplierData['to_date']=$request->to_date;
$supplierData['the_final_Balance']=refresh_account_blance_supplier($supplierData['account_number'],new Account(),new Supplier(),new Treasuries_transactions(),new Suppliers_with_orders(),new services_with_orders() ,true);
$supplierData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->sum('money_for_account');
$supplierData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$supplierData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->sum('money_for_account');
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$supplierData['from_date'])->where('move_date','<=',$supplierData['to_date'])->where('account_number','=',$supplierData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$supplierData['report_type']=$request->report_type;
return view('admin.financialReport.print_supplier_account_mirrorMoney',['data'=>$supplierData,'systemData'=>$systemData,'details'=>$details]);
}
}else{
$com_code=auth()->user()->com_code;
$suppliers=get_cols_where(new Supplier(),array("suuplier_code","name","date"),array("com_code"=>$com_code));
return view('admin.financialReport.index',['suppliers'=>$suppliers]);
}
} 
public function customer_account_mirror(Request $request){
if($_POST){
$com_code=auth()->user()->com_code;
$CustomerData=get_cols_where_row(new Customer(),array("account_number","start_balance","name","phones","date","customer_code"),array("com_code"=>$com_code,'customer_code'=>$request->customer_code));
if(empty($CustomerData)){
return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي بيانات هذا العميل !!']);
}
//General Report لو تقرير اجمالي
if($request->report_type==1){
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->count();
$CustomerData['SalesReturnCounter']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->count();
$CustomerData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->sum('money_for_account');
$CustomerData['salesReturnTotalMoney']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->sum('money_for_account');
$CustomerData['salesReturnTotalMoney']=$CustomerData['salesReturnTotalMoney']*(-1);
$CustomerData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->count();
$CustomerData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->count();
$CustomerData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->sum('money_for_account');
$CustomerData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->sum('money_for_account');
$CustomerData['ServicesForUsMoney']=$CustomerData['ServicesForUsMoney']*(-1);
$CustomerData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->sum('money_for_account');
$CustomerData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->sum('money_for_account');
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
return view('admin.financialReport.customer.print_customer_account_mirror',['data'=>$CustomerData,'systemData'=>$systemData]);
//تفصيلي
}elseif($request->report_type==2){
$CustomerData['from_date']=$request->from_date;
$CustomerData['to_date']=$request->to_date;
$CustomerData['Does_show_items']=$request->Does_show_items;
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->count();
$CustomerData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['SalesReturnCounter']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->count();
$CustomerData['salesReturnTotalMoney']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['salesReturnTotalMoney']=$CustomerData['salesReturnTotalMoney']*(-1);
$CustomerData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->count();
$CustomerData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->count();
$CustomerData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['ServicesForUsMoney']=$CustomerData['ServicesForUsMoney']*(-1);
$CustomerData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$details['sales']=Sales_invoices::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain')->where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->get();
if($CustomerData['Does_show_items']==1){
foreach( $details['sales'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Sales_invoices_details(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$Bur->auto_serial));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
// حرجعلها 
$details['sales_return']=SalesReturn::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain')->where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->get();
if($CustomerData['Does_show_items']==1){ 
foreach(  $details['sales_return'] as $return){  
$return->itemsdetails=get_cols_where(new SalesReturnDetails(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$return->auto_serial));
if(!empty($return->itemsdetails)){
foreach($return->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->where('account_number','=',$CustomerData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
}
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$CustomerData['account_number'] ])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($CustomerData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
if($CustomerData['Does_show_items']==1){
return view('admin.financialReport.customer.print_customer_account_mirrorIndetails_items',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
}else{
return view('admin.financialReport.customer.print_customer_account_mirrorIndetails',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
}
//المبيعات خلال الفترة
}elseif($request->report_type==3){
$CustomerData['from_date']=$request->from_date;
$CustomerData['to_date']=$request->to_date;
$CustomerData['Does_show_items']=$request->Does_show_items;
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->count();
$CustomerData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$details['sales']=Sales_invoices::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain')->where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->get();
if($CustomerData['Does_show_items']==1){
foreach( $details['sales'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Sales_invoices_details(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$Bur->auto_serial));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
return view('admin.financialReport.customer.print_customer_account_mirrorsales',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
//مرتجع مبيعات خلال الفترة
}elseif($request->report_type==4){
$CustomerData['from_date']=$request->from_date;
$CustomerData['to_date']=$request->to_date;
$CustomerData['Does_show_items']=$request->Does_show_items;
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['SalesReturnCounter']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->count();
$CustomerData['salesReturnTotalMoney']=SalesReturn::where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['salesReturnTotalMoney']=$CustomerData['salesReturnTotalMoney']*(-1);
$details['sales_return']=SalesReturn::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain')->where(["com_code"=>$com_code,'customer_code'=>$request->customer_code,'account_number'=>$CustomerData['account_number']])->where('invoice_date','>=',$CustomerData['from_date'])->where('invoice_date','<=',$CustomerData['to_date'])->get();
if($CustomerData['Does_show_items']==1){ 
foreach(  $details['sales_return'] as $return){  
$return->itemsdetails=get_cols_where(new SalesReturnDetails(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$return->auto_serial));
if(!empty($return->itemsdetails)){
foreach($return->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
return view('admin.financialReport.customer.print_customer_account_mirrorSalesReturn',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
//حركة الخدمات خلال الفترة
}elseif($request->report_type==6){
$CustomerData['from_date']=$request->from_date;
$CustomerData['to_date']=$request->to_date;
$CustomerData['Does_show_items']=$request->Does_show_items;
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->count();
$CustomerData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->count();
$CustomerData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>1])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$CustomerData['account_number'],'order_type'=>2])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['ServicesForUsMoney']=$CustomerData['ServicesForUsMoney']*(-1);
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$CustomerData['account_number'] ])->where('order_date','>=',$CustomerData['from_date'])->where('order_date','<=',$CustomerData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($CustomerData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
return view('admin.financialReport.customer.print_customer_account_Services',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
}
//حركة النقدية خلال الفترة
else{
$CustomerData['from_date']=$request->from_date;
$CustomerData['to_date']=$request->to_date;
$CustomerData['the_final_Balance']=refresh_account_blance_customer($CustomerData['account_number'], new Account(), new Customer(), new Treasuries_transactions(), new Sales_invoices(),new SalesReturn(),new services_with_orders(), true);
$CustomerData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$CustomerData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$CustomerData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->sum('money_for_account');
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$CustomerData['from_date'])->where('move_date','<=',$CustomerData['to_date'])->where('account_number','=',$CustomerData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$CustomerData['report_type']=$request->report_type;
return view('admin.financialReport.customer.print_customer_account_mirrorMoney',['data'=>$CustomerData,'systemData'=>$systemData,'details'=>$details]);
}
}else{
$com_code=auth()->user()->com_code;
return view('admin.financialReport.customer.index');
}
} 
public function searchforcustomer(Request $request){
if($request->ajax()){
$com_code=auth()->user()->com_code;
$searchtext=$request->searchtext;
if($searchtext!=""){
$customers=Customer::select('name','customer_code','date')->where('name','like',"%{$searchtext}%")->orWhere('customer_code','=',$searchtext)->orderby('id','asc')->limit(10)->get();
}else{
$customers=array();
}
return view('admin.financialReport.customer.get_searchforcustomer_result',['customers'=>$customers]);
}
}
public function delegate_account_mirror(Request $request){
if($_POST){
$com_code=auth()->user()->com_code;
$delegateData=get_cols_where_row(new Delegate(),array("account_number","start_balance","name","phones","date","delegate_code"),array("com_code"=>$com_code,'delegate_code'=>$request->delegate_code));
if(empty($delegateData)){
return redirect()->back()->with(['error'=>'عفوا غير قادر علي الوصول الي بيانات هذا العميل !!']);
}
//General Report لو تقرير اجمالي
if($request->report_type==1){
$delegateData['the_final_Balance']=refresh_account_blance_delegate($delegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),true);
$delegateData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->count();
$delegateData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->sum('total_cost');
$delegateData['total_delegate_commission_value']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->sum('delegate_commission_value');
$delegateData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->count();
$delegateData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->count();
$delegateData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->sum('money_for_account');
$delegateData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->sum('money_for_account');
$delegateData['ServicesForUsMoney']=$delegateData['ServicesForUsMoney']*(-1);
$delegateData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->sum('money_for_account');
$delegateData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->sum('money_for_account');
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$delegateData['report_type']=$request->report_type;
return view('admin.financialReport.delegate.print_delegate_account_mirror',['data'=>$delegateData,'systemData'=>$systemData]);
//تفصيلي
}elseif($request->report_type==2){
$delegateData['from_date']=$request->from_date;
$delegateData['to_date']=$request->to_date;
$delegateData['Does_show_items']=$request->Does_show_items;
$delegateData['the_final_Balance']=refresh_account_blance_delegate($delegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),true);
$delegateData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->count();
$delegateData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->sum('money_for_account');
$delegateData['total_delegate_commission_value']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->sum('delegate_commission_value');
$delegateData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->count();
$delegateData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->count();
$delegateData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->sum('money_for_account');
$delegateData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->sum('money_for_account');
$delegateData['ServicesForUsMoney']=$delegateData['ServicesForUsMoney']*(-1);
$delegateData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->sum('money_for_account');
$delegateData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->sum('money_for_account');
$details['sales']=Sales_invoices::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain','delegate_commission_value')->where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->get();
if($delegateData['Does_show_items']==1){
foreach( $details['sales'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Sales_invoices_details(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$Bur->auto_serial));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$delegateData['account_number'] ])->where('order_date','>=',$delegateData['from_date'])->where('order_date','<=',$delegateData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($delegateData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->where('account_number','=',$delegateData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$delegateData['report_type']=$request->report_type;
if($delegateData['Does_show_items']==1){
return view('admin.financialReport.delegate.print_delegate_account_mirrorIndetails_items',['data'=>$delegateData,'systemData'=>$systemData,'details'=>$details]);
}else{
return view('admin.financialReport.delegate.print_delegate_account_mirrorIndetails',['data'=>$delegateData,'systemData'=>$systemData,'details'=>$details]);
}
//المبيعات خلال الفترة
}
}
elseif($request->report_type==3){
$delegateData['from_date']=$request->from_date;
$delegateData['to_date']=$request->to_date;
$delegateData['Does_show_items']=$request->Does_show_items;
$delegateData['the_final_Balance']=refresh_account_blance_delegate($delegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),true);
$delegateData['SalesCounter']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->count();
$delegateData['SalesTotalMoney']=Sales_invoices::where(["com_code"=>$com_code,'customer_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->sum('money_for_account');
$delegateData['total_delegate_commission_value']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->sum('delegate_commission_value');
$details['sales']=Sales_invoices::select('auto_serial','invoice_date','is_approved','total_cost','pill_type','what_paid','what_remain','delegate_commission_value')->where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->get();
if($delegateData['Does_show_items']==1){
foreach( $details['sales'] as $Bur){
$Bur->itemsdetails=get_cols_where(new Sales_invoices_details(),array("*"),array("com_code"=>$com_code,"sales_invoices_auto_serial"=>$Bur->auto_serial));
if(!empty($Bur->itemsdetails)){
foreach($Bur->itemsdetails as $info){
$info->item_card_name = Inv_itemCard::where('item_code', $info->item_code)->value('name');
$info->uom_name = get_field_value(new Inv_uom(), "name", array("id" => $info->uom_id));
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$delegateData['report_type']=$request->report_type;
return view('admin.financialReport.delegate.print_delegate_account_mirrorsales',['data'=>$delegateData,'systemData'=>$systemData,'details'=>$details]);
} //الخدمات خلال فترة
elseif($request->report_type==6){
$delegateData['from_date']=$request->from_date;
$delegateData['to_date']=$request->to_date;
$delegateData['Does_show_items']=$request->Does_show_items;
$delegateData['the_final_Balance']=refresh_account_blance_delegate($delegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),true);
$delegateData['ServicesForUsCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->count();
$delegateData['ServicesForotherCounter']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->count();
$delegateData['ServicesForUsMoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>1])->sum('money_for_account');
$delegateData['ServicesForothermoney']=services_with_orders::where(["com_code"=>$com_code,'is_account_number'=>1,'account_number'=>$delegateData['account_number'],'order_type'=>2])->sum('money_for_account');
$delegateData['ServicesForUsMoney']=$delegateData['ServicesForUsMoney']*(-1);
$details['services_orders']=services_with_orders::select("*")->where(["com_code"=>$com_code,"is_account_number"=>1,'account_number'=>$delegateData['account_number'] ])->where('order_date','>=',$delegateData['from_date'])->where('order_date','<=',$delegateData['to_date'])->orderby('order_date','ASC')->orderby('order_type','ASC')->get();
if($delegateData['Does_show_items']==1){ 
if (!empty($details['services_orders'])) {
foreach ($details['services_orders'] as $info) {
$info->ServicesDetails=get_cols_where(new services_with_orders_details(),array("*"),array("com_code"=>$com_code,'services_with_orders_auto_serial'=>$info->auto_serial,'order_type'=>$info->order_type));
if(!empty( $info->ServicesDetails)){
foreach ($info->ServicesDetails as $serv) {
$serv->service_name = Services::where('id', $serv->service_id)->value('name');
} 
}
}
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$delegateData['report_type']=$request->report_type;
return view('admin.financialReport.delegate.print_delegate_account_mirroServices',['data'=>$delegateData,'systemData'=>$systemData,'details'=>$details]);
}
else{
$delegateData['from_date']=$request->from_date;
$delegateData['to_date']=$request->to_date;
$delegateData['the_final_Balance']=refresh_account_blance_delegate($delegateData['account_number'],new Account(),new Delegate(),new Treasuries_transactions(),new Sales_invoices(),new services_with_orders(),true);
$delegateData['total_delegate_commission_value']=Sales_invoices::where(["com_code"=>$com_code,'delegate_code'=>$request->delegate_code])->where('invoice_date','>=',$delegateData['from_date'])->where('invoice_date','<=',$delegateData['to_date'])->sum('delegate_commission_value');
$delegateData['treasuries_transactionsExchange']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','>',0)->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->sum('money_for_account');
$delegateData['treasuries_transactionsCollect']=Treasuries_transactions::where(["com_code"=>$com_code,'account_number'=>$delegateData['account_number'],'is_account'=>1])->where('money_for_account','<',0)->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->sum('money_for_account');
$details['Treasuries_transactions']=Treasuries_transactions::select('auto_serial','money_for_account','byan','mov_type','move_date','treasuries_id')->where('move_date','>=',$delegateData['from_date'])->where('move_date','<=',$delegateData['to_date'])->where('account_number','=',$delegateData['account_number'])->get();
if(!empty( $details['Treasuries_transactions'])){
foreach( $details['Treasuries_transactions'] as $info){
if($info->money_for_account<0) {
$info->money_for_account=$info->money_for_account*(-1);
}
$info->mov_type_name=get_field_value(new Mov_type(),'name',array('id'=>$info->mov_type));
}
}
$systemData=get_cols_where_row(new Admin_panel_setting(),array("system_name","phone","address","photo"),array("com_code"=>$com_code));
$delegateData['report_type']=$request->report_type;
return view('admin.financialReport.delegate.print_delegate_account_mirrorMoney',['data'=>$delegateData,'systemData'=>$systemData,'details'=>$details]);
}
}else{
$com_code=auth()->user()->com_code;
$delegates=get_cols_where(new Delegate(),array('delegate_code','name','date'),array('com_code'=>$com_code));
return view('admin.financialReport.delegate.index',['delegates'=>$delegates]);
}
} 
}