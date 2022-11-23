<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Services;


class ServicesController extends Controller
{
    
public function index(){

    try{
 $com_code=auth()->user()->com_code;
$data=get_cols_where_p(new Services(),array("*"),array("com_code"=>$com_code),'id','DESC');
if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }

    return view('admin.services.index',['data'=>$data]);



    }catch(\Exception $ex){
 return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما']);
    }


}


}
