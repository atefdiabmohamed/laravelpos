<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 130 ساعة بالكورس الي نهاية الدورة الفيدو رقم  231- اما باقي أكواد الدورة الثانية للتطوير النظام موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
return view('admin.dashboard');
    }
}
