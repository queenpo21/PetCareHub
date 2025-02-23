<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GioithieuController extends Controller
{
    public function index(){
        return view('pages.gioithieu');
    }
}
