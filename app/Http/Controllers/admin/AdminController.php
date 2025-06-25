<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $admin;
    public function __construct()
    {
        $this->admin = new Admin();
    }
    public function logout(Request $request){
        $request->session()->forget('userName');
        return redirect()->route('homepage');
    }
}
