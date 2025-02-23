<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FootController extends Controller
{
    public function ChinhSachDoiTra(){
        return view('pages.doitra');
    }
    public function ChinhSachHoanTien(){
        return view('pages.hoantien');
    }
    public function PhuongThucThanhToan(){
        return view('pages.ptthanhtoan');
    }
    public function ChinhSachBaoMat(){
        return view('pages.baomat');
    }
}
