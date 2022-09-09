<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\Account;
use App\Models\Admin_panel_setting;


use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
   
    public function index()
  {
    $com_code = auth()->user()->com_code;
    $data = get_cols_where_p(new Customer(), array("*"), array("com_code" => $com_code), 'id', 'DESC', PAGINATION_COUNT);
    if (!empty($data)) {
      foreach ($data as $info) {
        $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
        if ($info->updated_by > 0 and $info->updated_by != null) {
          $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
        }
       
      }
    }

    return view('admin.customers.index', ['data' => $data]);
  }
  public function create(){
    return view('admin.customers.create');

  }
  

  
  public function store(CustomerRequest $request)
  {

    try {

      $com_code = auth()->user()->com_code;
    
      //check if not exsits for name
      $checkExists_name = get_cols_where_row(new Customer(), array("id"), array('name' => $request->name, 'com_code' => $com_code));

      if (!empty($checkExists_name)) {
        return redirect()->back()
          ->with(['error' => 'عفوا اسم العميل مسجل من قبل'])
          ->withInput();
      }
      
      //set customer code
      $row = get_cols_where_row_orderby(new Customer(), array("customer_code"), array("com_code" => $com_code), 'id', 'DESC');
      if (!empty($row)) {
        $data_insert['customer_code'] = $row['customer_code'] + 1;
      } else {
        $data_insert['customer_code'] = 1;
      }

 //set account number
 $row = get_cols_where_row_orderby(new Account(), array("account_number"), array("com_code" => $com_code), 'id', 'DESC');
 if (!empty($row)) {
   $data_insert['account_number'] = $row['account_number'] + 1;
 } else {
   $data_insert['account_number'] = 1;
 }


      $data_insert['name'] = $request->name;
      $data_insert['address'] = $request->address;
      $data_insert['start_balance_status'] = $request->start_balance_status;
      if ($data_insert['start_balance_status'] == 1) {
        //credit
        $data_insert['start_balance'] = $request->start_balance * (-1);
      } elseif ($data_insert['start_balance_status'] == 2) {
        //debit
        $data_insert['start_balance'] = $request->start_balance;
        if ($data_insert['start_balance'] < 0) {
          $data_insert['start_balance'] = $data_insert['start_balance'] * (-1);
        }
      } elseif ($data_insert['start_balance_status'] == 3) {
        //balanced
        $data_insert['start_balance'] = 0;
      } else {
        $data_insert['start_balance_status'] = 3;
        $data_insert['start_balance'] = 0;
      }


      $data_insert['notes'] = $request->notes;
      $data_insert['active'] = $request->active;
      $data_insert['added_by'] = auth()->user()->id;
      $data_insert['created_at'] = date("Y-m-d H:i:s");
      $data_insert['date'] = date("Y-m-d");
      $data_insert['com_code'] = $com_code;
      $flag=insert(new Customer(),$data_insert);
    if($flag){
      //insert into accounts
      $data_insert_account['name'] = $request->name;
      $data_insert_account['start_balance_status'] = $request->start_balance_status;
      if ($data_insert_account['start_balance_status'] == 1) {
        //credit
        $data_insert_account['start_balance'] = $request->start_balance * (-1);
      } elseif ($data_insert_account['start_balance_status'] == 2) {
        //debit
        $data_insert_account['start_balance'] = $request->start_balance;
        if ($data_insert_account['start_balance'] < 0) {
          $data_insert_account['start_balance'] = $data_insert_account['start_balance'] * (-1);
        }
      } elseif ($data_insert_account['start_balance_status'] == 3) {
        //balanced
        $data_insert_account['start_balance'] = 0;
      } else {
        $data_insert_account['start_balance_status'] = 3;
        $data_insert_account['start_balance'] = 0;
      }

      $customer_parent_account_number=get_field_value(new Admin_panel_setting(),"customer_parent_account_number",array('com_code'=>$com_code));
      $data_insert_account['notes'] = $request->notes;
      $data_insert_account['parent_account_number']=$customer_parent_account_number;
      $data_insert_account['is_parent']=0;
      $data_insert_account['account_number'] = $data_insert['account_number'];
      $data_insert_account['account_type'] = 3;
      $data_insert_account['is_archived'] = $request->active;
      $data_insert_account['added_by'] = auth()->user()->id;
      $data_insert_account['created_at'] = date("Y-m-d H:i:s");
      $data_insert_account['date'] = date("Y-m-d");
      $data_insert_account['com_code'] = $com_code;
      $data_insert_account['other_table_FK']=$data_insert['customer_code'] ;
      $flag=insert(new Account(),$data_insert_account);



    }
      return redirect()->route('admin.customer.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    } catch (\Exception $ex) {

      return redirect()->back()
        ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
        ->withInput();
    }
  }

}
