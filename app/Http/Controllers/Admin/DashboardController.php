<?php
//لاتنسونا من صالح الدعاء وجزاكم الله خيرا
//هذا الكود الي الفيدو رقم 190 وباقي  الأكود موجوده ببقية الفيدوهات ولابد ان تكتبها بنفسك لأهميتها 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
return view('admin.dashboard');
    }
}
