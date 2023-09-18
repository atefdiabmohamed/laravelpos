<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Sales_matrial_types;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SalesMatiralTypesRequest;
class Sales_matrial_typesController extends Controller
{
public function index()
{
$data = Sales_matrial_types::select()->orderby('id', 'DESC')->paginate(PAGINATION_COUNT);
if (!empty($data)) {
foreach ($data as $info) {
$info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
if ($info->updated_by > 0 and $info->updated_by != null) {
$info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
}
}
}
return view('admin.sales_matrial_types.index', ['data' => $data]);
}
public function create()
{
return view('admin.sales_matrial_types.create');
}
public function store(SalesMatiralTypesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
//check if not exsits
$checkExists = Sales_matrial_types::where(['name' => $request->name, 'com_code' => $com_code])->first();
if ($checkExists == null) {
$data['name'] = $request->name;
$data['active'] = $request->active;
$data['created_at'] = date("Y-m-d H:i:s");
$data['added_by'] = auth()->user()->id;
$data['com_code'] = $com_code;
$data['date'] = date("Y-m-d");
Sales_matrial_types::create($data);
return redirect()->route('admin.sales_matrial_types.index')->with(['success' => 'لقد تم اضافة البيانات بنجاح']);
} else {
return redirect()->back()
->with(['error' => 'عفوا اسم الفئة مسجل من قبل'])
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
$data = Sales_matrial_types::select()->find($id);
return view('admin.sales_matrial_types.edit', ['data' => $data]);
}
public function update($id, SalesMatiralTypesRequest $request)
{
try {
$com_code = auth()->user()->com_code;
$data = Sales_matrial_types::select()->find($id);
if (empty($data)) {
return redirect()->route('admin.sales_matrial_types.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
}
$checkExists = Sales_matrial_types::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $id)->first();
if ($checkExists != null) {
return redirect()->back()
->with(['error' => 'عفوا اسم الخزنة مسجل من قبل'])
->withInput();
}
$data_to_update['name'] = $request->name;
$data_to_update['active'] = $request->active;
$data_to_update['updated_by'] = auth()->user()->id;
$data_to_update['updated_at'] = date("Y-m-d H:i:s");
Sales_matrial_types::where(['id' => $id, 'com_code' => $com_code])->update($data_to_update);
return redirect()->route('admin.sales_matrial_types.index')->with(['success' => 'لقد تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->back()
->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
->withInput();
}
}
public function delete($id)
{
try {
$Sales_matrial_types_row = Sales_matrial_types::find($id);
if (!empty($Sales_matrial_types_row)) {
$flag = $Sales_matrial_types_row->delete();
if ($flag) {
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