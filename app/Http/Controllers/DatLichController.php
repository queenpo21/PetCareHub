<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatLichController extends Controller
{
    public function index()
    {
        return view('pages.datlich'); 
    }
    public function luuThongTin(Request $request)
    {
        $data = $request->all(); 
        $dichVu = implode(', ', $data['dich_vu']);

        session()->flash('dat_lich', [
            'ho_ten' => $data['ho_ten'],
            'email' => $data['email'],
            'ngay_dat' => $data['ngay_dat'],
            'dich_vu' => $dichVu,
        ]);

        return redirect()->route('admin.dslichhen');
    }

}

