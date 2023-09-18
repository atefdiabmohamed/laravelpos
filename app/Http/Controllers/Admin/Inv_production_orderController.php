<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Inv_production_order;
use App\Http\Requests\inv_production_orderRequest;
use App\Models\Inv_stores_inventory;

class Inv_production_orderController extends Controller
{
public function index(){
try{
$com_code=auth()->user()->com_code;
$data=get_cols_where_p(new Inv_production_order(),array("*"),array("com_code"=>$com_code),'id','DESC',PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
if ($info->is_approved==1) {
    $info->approved_by_admin = Admin::where('id', $info->approved_by)->value('name');
    }
    if ($info->is_closed==1) {
        $info->closed_by_admin = Admin::where('id', $info->closed_by)->value('name');
        }
    

}
}
return view('admin.inv_production_order.index',['data'=>$data]);
}catch(\Exception $ex){
return redirect()->back()->with(['error'=>'عفوا حدث خطأ ما']);
}
}
public function create(){
return view('admin.inv_production_order.create');
}
public function store(inv_production_orderRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$row = get_cols_where_row_orderby(new Inv_production_order(), array("auto_serial"), array("com_code" => $com_code), 'id', 'DESC');
if (!empty($row)) {
$data['auto_serial'] = $row['auto_serial'] + 1;
} else {
$data['auto_serial'] = 1;
}
$data['production_plane'] = $request->production_plane;
$data['production_plan_date'] = $request->production_plan_date;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
insert(new Inv_production_order(),$data);
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}

public function edit($id)
{
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if ($data['is_closed'] == 1) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}
return view('admin.inv_production_order.edit', ['data' => $data]);


}

public function update($id, inv_production_orderRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("*"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
if($data['is_closed'] == 1) {
return redirect()->route('admin.inv_production_order.index')->with(['error' => 'عفوا لايمكن التحديث علي فاتورة معتمدة ومؤرشفة']);
}

$data_to_update['production_plan_date'] = $request->production_plan_date;
$data_to_update['production_plane'] = $request->production_plane;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
update(new Inv_production_order(), $data_to_update, array("id" => $id, "com_code" => $com_code));
return redirect()->route('admin.inv_production_order.index', $id)->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
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
$data = get_cols_where_row(new Inv_production_order(), array("is_closed"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($data['is_closed'] == 1) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن حذف  أمر  تشغيل معتمد ومؤرشف ']);
}
//هنا حنعمل مستقبلا  التشيك علي عدم استخدامه في اوامر الصرف الداخلية من مخازن الخامات للورش

$flag = delete(new Inv_production_order(), array("id" => $id, "com_code" => $com_code));
if ($flag) {
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم حذف  البيانات بنجاح']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function show_more_detials(Request $request)
{
if ($request->ajax()) {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new  Inv_production_order(), array("*"), array("id" => $request->id, "com_code" => $com_code));
if (!empty($data)) {
if($data['updated_by']>0)
{
    $data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
}

}
return view('admin.inv_production_order.show_more_detials', ['data' => $data]);

}
}

public function do_approve($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("is_approved"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($data['is_closed'] == 1) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن حذف  أمر  تشغيل معتمد ومؤرشف ']);
}
if ($data['is_approved'] == 1) {
    return redirect()->back()
    ->with(['error' => 'عفوا  هذا الامر بالفعل معتمد من قبل ! ']);
    }
    
    $data_to_update['is_approved'] = 1;
    $data_to_update['approved_by'] = auth()->user()->id;
    $data_to_update['approved_at'] = date("Y-m-d H:i:s");
    $flag=update(new Inv_production_order(), $data_to_update, array("id" => $id, "com_code" => $com_code));

if ($flag) {
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم اعتماد  امر التشغيل   بنجاح']);
}else{
    return redirect()->back()
->with(['error' => '  عفوا لم يتم العملية من فضلك حاول مرةأخري ']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function do_closes_archive($id)
{
try {
$com_code = auth()->user()->com_code;
$data = get_cols_where_row(new Inv_production_order(), array("is_approved","is_closed"), array("id" => $id, "com_code" => $com_code));
if (empty($data)) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما']);
}
if ($data['is_approved'] == 0) {
return redirect()->back()
->with(['error' => 'عفوا  لايمكن اغلاق  أمر  تشغيل غير معتمد  ']);
}
if ($data['is_closed'] == 1) {
    return redirect()->back()
    ->with(['error' => 'عفوا  هذا الامر بالفعل مغلق  من قبل ! ']);
    }
    //مستقبلا حنشيك علي استخدامه بالفعل داخل حركات ورش الانتاج
    $data_to_update['is_closed'] = 1;
    $data_to_update['closed_by'] = auth()->user()->id;
    $data_to_update['closed_at'] = date("Y-m-d H:i:s");
    $flag=update(new Inv_production_order(), $data_to_update, array("id" => $id, "com_code" => $com_code));

if ($flag) {
return redirect()->route('admin.inv_production_order.index')->with(['success' => 'لقد تم اعتماد  امر التشغيل   بنجاح']);
}else{
    return redirect()->back()
->with(['error' => '  عفوا لم يتم العملية من فضلك حاول مرةأخري ']);
}
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}

public function ajax_search(Request $request)
{
if ($request->ajax()) {
    $com_code = auth()->user()->com_code;

$search_by_text = $request->search_by_text;
$close_search = $request->close_search;
$approve_search = $request->approve_search;
$from_date_search = $request->from_date_search;
$to_date_search = $request->to_date_search;
if ($search_by_text == '') {
//دائما  true
$field1 = "id";
$operator1 = ">";
$value1 = 0;
} else {
$field1 = "auto_serial";
$operator1 = "=";
$value1 = $search_by_text;
}
if ($close_search == 'all') {
//دائما  true
$field2 = "id";
$operator2 = ">";
$value2 = 0;
} else {
$field2 = "is_closed";
$operator2 = "=";
$value2 = $close_search;
}

if ($approve_search == 'all') {
    //دائما  true
    $field3 = "id";
    $operator3 = ">";
    $value3 = 0;
    } else {
    $field3 = "is_approved";
    $operator3 = "=";
    $value3 = $approve_search;
    }

if ($from_date_search == '') {
//دائما  true
$field4 = "id";
$operator4 = ">";
$value4= 0;
} else {
$field4 = "production_plan_date";
$operator4 = ">=";
$value4 = $from_date_search;
}

if ($to_date_search == '') {
    //دائما  true
    $field5 = "id";
    $operator5 = ">";
    $value5= 0;
    } else {
    $field5 = "production_plan_date";
    $operator5 = "<=";
    $value5 = $to_date_search;
    }

$data = inv_production_order::where($field1, $operator1, $value1)->where($field2, $operator2, $value2)->where($field3, $operator3, $value3)->where($field4, $operator4, $value4)->where($field5, $operator5, $value5)->where('com_code','=',$com_code)->orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
    foreach ($data as $info) {
    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
    if ($info->updated_by > 0 and $info->updated_by != null) {
    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
    }
    if ($info->is_approved==1) {
        $info->approved_by_admin = Admin::where('id', $info->approved_by)->value('name');
        }
        if ($info->is_closed==1) {
            $info->closed_by_admin = Admin::where('id', $info->closed_by)->value('name');
            }
        
    
    }
    }
return view('admin.inv_production_order.ajax_search', ['data' => $data]);
}
}


}