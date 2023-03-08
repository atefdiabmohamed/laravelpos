<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//أخي الكريم هذا الكود هو اول 127 ساعة بالكورس الي الفيدو رقم 190 - اما باقي الاكواد موجوده بالدورة ولابد ان تكتبها بنفسك لأهميتها وللإستفادة

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
return view('admin.dashboard');
    }
}
