<?php
//لاتنسونا من صالح الدعاء
//أخي الكريم هذا الكود هو اول 100 ساعة بالكورس الي نهاية الدورة الفيدو رقم  190- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
class LoginController extends Controller
{
public function show_login_view(){
return view('admin.auth.login');
}
public function login(LoginRequest $request){
if(auth()->guard('admin')->attempt(['username'=>$request->input('username'),'password'=>$request->input('password')]))
{
return redirect()->route('admin.dashboard'); 
}else{
 
return redirect()->route('admin.showlogin')->with(['error' => 'عفوا بيانات تسجيل الدخول غير صحيحة !!']);; 
}
}
public function logout(){
auth()->logout();
return redirect()->route('admin.showlogin');
}
/*
function make_new_admin(){
$admin=new App\Models\Admin();
$admin->name='admin';
$admin->email='test@gmail.com';
$admin->username='admin';
$admin->password=bcrypt("admin");
$admin->com_code=1;
$admin->save();
}
*/
}