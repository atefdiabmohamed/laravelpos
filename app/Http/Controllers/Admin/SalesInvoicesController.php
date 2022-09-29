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
use App\Models\Treasuries_transactions;
use App\Models\Treasuries;
use App\Models\Admins_Shifts;
use App\Models\Delegate;

class SalesInvoicesController extends Controller
{

  public function index()
  {

    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new Sales_invoices(), array("*"), array("com_code" => $com_code), "id", "DESC", PAGINATION_COUNT);
    if (!empty($data)) {
      foreach ($data as $info) {
        $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
        $info->Sales_matrial_types_name = get_field_value(new Sales_matrial_types(), "name", array("com_code" => $com_code, "id" => $info->sales_matrial_types));
        if ($info->is_has_customer == 1) {
          $info->customer_name = get_field_value(new Customer(), "name", array("com_code" => $com_code, "customer_code" => $info->customer_code));
        } else {
          $info->customer_name = "بدون عميل";
        }
      }



      return view("admin.sales_invoices.index", ['data' => $data]);
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
  //مرآة فاتوةر موقته للعميل لاتؤثر علي اي شيء  مجرد عرض سعر 
  public function load_modal_addMirror(Request $request)
  {
    $com_code = auth()->user()->com_code;

    if ($request->ajax()) {
      $item_cards = get_cols_where(new Inv_itemCard(), array("item_code", "name", "item_type"), array("com_code" => $com_code, "active" => 1));
      $stores = get_cols_where(new Store(), array("id", "name"), array("com_code" => $com_code, "active" => 1), 'id', 'ASC');
      $user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());

      return view("admin.sales_invoices.loadModalAddInvoiceMirror", ['item_cards' => $item_cards, 'stores' => $stores, 'user_shift' => $user_shift]);
    }
  }


//عرض صفحة اضافة فاتورة مبيعات فعلية ذات الخصم اللحظي للأصناف من المخازن  
public function load_modal_addActiveInvoice(Request $request)
{
  $com_code = auth()->user()->com_code;

  if ($request->ajax()) {
    $item_cards = get_cols_where(new Inv_itemCard(), array("item_code", "name", "item_type"), array("com_code" => $com_code, "active" => 1));
    $stores = get_cols_where(new Store(), array("id", "name"), array("com_code" => $com_code, "active" => 1), 'id', 'ASC');
    $user_shift = get_user_shift(new Admins_Shifts(), new Treasuries(), new Treasuries_transactions());
    $delegates=get_cols_where(new Delegate(),array("delegate_code","name"),array("com_code" => $com_code, "active" => 1));
    $customers=get_cols_where(new Customer(),array("customer_code","name"),array("com_code" => $com_code, "active" => 1));
    $Sales_matrial_types=get_cols_where(new Sales_matrial_types(),array("id","name"),array("com_code" => $com_code, "active" => 1));
    
    return view("admin.sales_invoices.load_modal_addActiveInvoice", ['item_cards' => $item_cards, 'stores' => $stores, 'user_shift' =>
     $user_shift,'delegates'=>$delegates,'customers'=>$customers,'Sales_matrial_types'=>$Sales_matrial_types]);
  }
}



  public function get_item_batches(Request $request)
  {
    $com_code = auth()->user()->com_code;

    if ($request->ajax()) {
      $item_card_Data = get_cols_where_row(new Inv_itemCard(), array("item_type", "uom_id", "retail_uom_quntToParent"), array("com_code" => $com_code, "item_code" => $request->item_code));
      if (!empty($item_card_Data)) {
        $requesed['uom_id'] = $request->uom_id;
        $requesed['store_id'] = $request->store_id;
        $requesed['item_code'] = $request->item_code;
        $parent_uom = $item_card_Data['uom_id'];
        $uom_Data = get_cols_where_row(new Inv_uom(), array("name", "is_master"), array("com_code" => $com_code, "id" => $requesed['uom_id']));
        if (!empty($uom_Data)) {
          //لو صنف مخزني يبقي ههتم بالتواريخ
          if ($item_card_Data['item_type'] == 2) {
            $inv_itemcard_batches = get_cols_where(
              new Inv_itemcard_batches(),
              array("unit_cost_price", "quantity", "production_date", "expired_date", "auto_serial"),
              array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "inv_uoms_id" => $parent_uom),
              'production_date',
              'ASC'
            );
          } else {
            $inv_itemcard_batches = get_cols_where(
              new Inv_itemcard_batches(),
              array("unit_cost_price", "quantity", "auto_serial"),
              array("com_code" => $com_code, "store_id" => $requesed['store_id'], "item_code" => $requesed['item_code'], "inv_uoms_id" => $parent_uom),
              'id',
              'ASC'
            );
          }


          return view("admin.sales_invoices.get_item_batches", ['item_card_Data' => $item_card_Data, 'requesed' => $requesed, 'uom_Data' => $uom_Data, 'inv_itemcard_batches' => $inv_itemcard_batches]);
        }
      }
    }
  }

  public function get_item_unit_price(Request $request)
  {
    $com_code = auth()->user()->com_code;

    if ($request->ajax()) {
      $item_card_Data = get_cols_where_row(new Inv_itemCard(), array("uom_id", "price", "nos_gomla_price", "gomla_price", "price_retail", "nos_gomla_price_retail", "gomla_price_retail", "does_has_retailunit", "retail_uom_id"), array("com_code" => $com_code, "item_code" => $request->item_code));
      if (!empty($item_card_Data)) {

        $uom_id = $request->uom_id;
        $sales_item_type = $request->sales_item_type;
        $uom_Data = get_cols_where_row(new Inv_uom(), array("is_master"), array("com_code" => $com_code, "id" => $uom_id));
        if (!empty($uom_Data)) {
          if ($uom_Data['is_master'] == 1) {

            if ($item_card_Data['uom_id'] == $uom_id) {
              if ($sales_item_type == 1) {
                echo json_encode($item_card_Data['price']);
              } elseif ($sales_item_type == 2) {
                echo json_encode($item_card_Data['nos_gomla_price']);
              } else {
                echo json_encode($item_card_Data['gomla_price']);
              }
            }
          } else {

            if ($item_card_Data['retail_uom_id'] == $uom_id and $item_card_Data['does_has_retailunit'] == 1) {

              if ($sales_item_type == 1) {
                echo json_encode($item_card_Data['price_retail']);
              } elseif ($sales_item_type == 2) {
                echo json_encode($item_card_Data['nos_gomla_price_retail']);
              } else {
                echo json_encode($item_card_Data['gomla_price_retail']);
              }
            }
          }
        }
      }
    }
  }

  public function get_Add_new_item_row(Request $request)
  {
    $com_code = auth()->user()->com_code;
    if ($request->ajax()) {

      $received_data['store_id'] = $request->store_id;
      $received_data['sales_item_type'] = $request->sales_item_type;
      $received_data['item_code'] = $request->item_code;
      $received_data['uom_id'] = $request->uom_id;
      $received_data['inv_itemcard_batches_id'] = $request->inv_itemcard_batches_id;
      $received_data['item_quantity'] = $request->item_quantity;
      $received_data['item_price'] = $request->item_price;
      $received_data['is_normal_orOther'] = $request->is_normal_orOther;
      $received_data['item_total'] = $request->item_total;
      $received_data['store_name'] = $request->store_name;
      $received_data['uom_id_name'] = $request->uom_id_name;
      $received_data['item_code_name'] = $request->item_code_name;

      $received_data['sales_item_type_name'] = $request->sales_item_type_name;
      $received_data['is_normal_orOther_name'] = $request->is_normal_orOther_name;
      $received_data['isparentuom'] = $request->isparentuom;
      return view('admin.sales_invoices.get_Add_new_item_row', ['received_data' => $received_data]);
    }
  }

  public function store(Request $request){
    if ($request->ajax()) {
      $com_code = auth()->user()->com_code;
   //حنعمل اضافة للفاتورة اول مرة 
   $com_code = auth()->user()->com_code;
   $last_auto_serial_Date = get_cols_where_row_orderby(new Sales_invoices(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
   if (!empty($last_auto_serial_Date)) {
       $data_insert['auto_serial'] = $last_auto_serial_Date['auto_serial'] + 1;
   } else {
       $data_insert['auto_serial'] = 1;
   }

   $data_insert['invoice_date'] = $request->invoice_date;
   $data_insert['is_has_customer'] = $request->is_has_customer;
     if($request->is_has_customer==1){
      $data_insert['customer_code'] = $request->customer_code;  
     }
   $data_insert['delegate_code'] = $request->delegate_code;
   $data_insert['sales_matrial_types'] = $request->sales_matrial_types;

   
   $data_insert['added_by'] = auth()->user()->id;
   $data_insert['created_at'] = date("Y-m-d H:i:s");
   $data_insert['date'] = date("Y-m-d");
   $data_insert['com_code'] = $com_code;
 $flagData=insert(new Sales_invoices(),$data_insert,true);
   if(!empty( $flagData)){ 
   echo json_encode("done");
   }

    }

  }





  
}
