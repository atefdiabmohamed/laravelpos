<?php

namespace App\Http\Controllers\Admin;
use App\Models\Account;
use App\Models\Account_types;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $data = Account::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
        if (!empty($data)) {
            foreach ($data as $info) {
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 and $info->updated_by != null) {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
                $info->account_types_name = Account_types::where('id', $info->account_types)->value('name');
              if($info->is_parent==0){
                $info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
   
              }else{
                $info->parent_account_name ="لايوجد";
              }
            }
        }

        return view('admin.accounts.index', ['data' => $data]);
    }
}
