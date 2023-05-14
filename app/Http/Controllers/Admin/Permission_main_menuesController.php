<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission_main_menues;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\Permission_main_menuesRequst;
use App\Models\Permission_sub_menues;

class Permission_main_menuesController extends Controller
{
    public function index()
    {
    $data = Permission_main_menues::select()->orderby('id', 'ASC')->paginate(PAGINATION_COUNT);
    if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    }
    }
    return view('admin.permission_main_menues.index', ['data' => $data]);
    }

    
    public function create()
    {
    return view('admin.permission_main_menues.create');
    }

    public function store(Permission_main_menuesRequst $request)
    {
    try {
    $com_code = auth()->user()->com_code;
    //check if not exsits
    $checkExists = Permission_main_menues::where(['name' => $request->name, 'com_code' => $com_code])->first();
    if ($checkExists == null) {
    $data['name'] = $request->name;
    $data['active'] = $request->active;
    $data['created_at'] = date("Y-m-d H:i:s");
    $data['added_by'] = auth()->user()->id;
    $data['com_code'] = $com_code;
    $data['date'] = date("Y-m-d");
    Permission_main_menues::create($data);
    return redirect()->route('admin.permission_main_menues.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
    } else {
    return redirect()->back()
    ->with(['error' => 'عفوا اسم الدور  مسجل من قبل'])
    ->withInput();
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
    ->withInput();
    }
    }

    public function edit($id)
    {
    $data = Permission_main_menues::select()->find($id);
    return view('admin.permission_main_menues.edit', ['data' => $data]);
    }
    public function update($id, Permission_main_menuesRequst $request)
    {
    try {
    $com_code = auth()->user()->com_code;
    $data = Permission_main_menues::select()->find($id);
    if (empty($data)) {
    return redirect()->route('admin.permission_main_menues.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
    }
    $checkExists = Permission_main_menues::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
    if ($checkExists != null) {
    return redirect()->back()
    ->with(['error' => 'عفوا اسم الصلاحية مسجل من قبل'])
    ->withInput();
    }
    $data_to_update['name'] = $request->name;
    $data_to_update['active'] = $request->active;
    $data_to_update['updated_by'] = auth()->user()->id;
    $data_to_update['updated_at'] = date("Y-m-d H:i:s");
    Permission_main_menues::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
    return redirect()->route('admin.permission_main_menues.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
    ->withInput();
    }
    }

    public function delete($id)
    {
    try {
        $com_code = auth()->user()->com_code;
    $item_row = Permission_main_menues::find($id);
    if (!empty($item_row)) {
    $flag = $item_row->delete();
    if ($flag) {
     delete(new Permission_sub_menues(),array("com_code"=>$com_code,'permission_main_menues_id'=>$id));   
    return redirect()->back()
    ->with(['success' => '   تم حذف البيانات بنجاح']);
    } else {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما']);
    }
    } else {
    return redirect()->back()
    ->with(['error' => 'عفوا غير قادر الي الوصول للبيانات المطلوبة']);
    }
    } catch (\Exception $ex) {
    return redirect()->back()
    ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
    }
    }
}
