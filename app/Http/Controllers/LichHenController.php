<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LichHenController extends Controller
{
    public function index(){
        return view('admin.admin_dslichhen');
    }
}
