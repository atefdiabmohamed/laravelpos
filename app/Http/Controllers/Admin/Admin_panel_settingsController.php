<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة
//حجم الدورة المتوقع هو 350 ساعة  - الاشتراك بكورس يودمي له مميزات الحصول علي كود الدورة الاولي الي الفيدو 351 لأول 190 ساعه بالدورة
//تبدأ الدورة الثانية للتطوير من الفيدو 351 وهي متاحه علي الانتساب او كورس يودمي
namespace App\Http\Controllers\Admin;
use App\Models\Admin_panel_setting;
use App\Models\Admin;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin_panel_settings_Request;
use Illuminate\Http\Request;
class Admin_panel_settingsController extends Controller
{
public function index()
{
    check_permission_sub_menue_actions_redirect(1);
$data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
if (!empty($data)) {
if ($data['updated_by'] > 0 and $data['updated_by'] != null) {
$data['updated_by_admin'] = Admin::where('id', $data['updated_by'])->value('name');
$data['customer_parent_account_name'] = Account::where('account_number', $data['customer_parent_account_number'])->value('name');
$data['supplier_parent_account_name'] = Account::where('account_number', $data['suppliers_parent_account_number'])->value('name');
$data['delegates_parent_account_name'] = Account::where('account_number', $data['delegate_parent_account_number'])->value('name');
$data['employees_parent_account_name'] = Account::where('account_number', $data['employees_parent_account_number'])->value('name');
$data['production_lines_parent_account_name'] = Account::where('account_number', $data['production_lines_parent_account'])->value('name');

}
}
return view('admin.admin_panel_settings.index', ['data' => $data]);
}
public function edit()
{
    check_permission_sub_menue_actions_redirect(2);
$data = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
$parent_accounts = get_cols_where(new Account(), array("account_number", "name"), array("is_parent" => 1, "com_code" => auth()->user()->com_code), 'id', 'ASC');
return view('admin.admin_panel_settings.edit', ['data' => $data, 'parent_accounts' => $parent_accounts]);
}
public function update(Admin_panel_settings_Request $request)
{
    check_permission_sub_menue_actions_redirect(2);
try {
$admin_panel_setting = Admin_panel_setting::where('com_code', auth()->user()->com_code)->first();
$admin_panel_setting->system_name = $request->system_name;
$admin_panel_setting->address = $request->address;
$admin_panel_setting->phone = $request->phone;
$admin_panel_setting->general_alert = $request->general_alert;
$admin_panel_setting->customer_parent_account_number = $request->customer_parent_account_number;
$admin_panel_setting->suppliers_parent_account_number = $request->suppliers_parent_account_number;
$admin_panel_setting->delegate_parent_account_number = $request->delegate_parent_account_number;
$admin_panel_setting->employees_parent_account_number = $request->employees_parent_account_number;
$admin_panel_setting->production_lines_parent_account = $request->production_lines_parent_account;
$admin_panel_setting->default_unit = $request->default_unit;

if($admin_panel_setting['is_set_Batches_setting']==0){
if(isset($request->Batches_setting_type))
$admin_panel_setting->is_set_Batches_setting = 1;
$admin_panel_setting->Batches_setting_type = $request->Batches_setting_type;

}



$admin_panel_setting->updated_by = auth()->user()->id;
$admin_panel_setting->updated_at = date("Y-m-d H:i:s");
$oldphotoPath = $admin_panel_setting->photo;
if ($request->has('photo')) {
$request->validate([
'photo' => 'required|mimes:png,jpg,jpeg|max:2000',
]);
$the_file_path = uploadImage('assets/admin/uploads', $request->photo);
$admin_panel_setting->photo = $the_file_path;
if (file_exists('assets/admin/uploads/' . $oldphotoPath) and !empty($oldphotoPath)) {
unlink('assets/admin/uploads/' . $oldphotoPath);
}
}
$admin_panel_setting->save();
return redirect()->route('admin.adminPanelSetting.index')->with(['success' => 'تم تحديث البيانات بنجاح']);
} catch (\Exception $ex) {
return redirect()->route('admin.adminPanelSetting.index')->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()]);
}
}
}