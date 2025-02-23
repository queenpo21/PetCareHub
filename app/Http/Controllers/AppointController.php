<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\appointment;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AppointController extends Controller
{
    use ValidatesRequests;

    public function index(){
        $app = appointment::with('customer')->get();
        return view('admin.admin_quanlylichhen', compact('app'));
    }
    public function timeslot(){
        $tim = appointment::ManageTimeSlot();
        return view ('admin.admin_khunggio',compact('tim') );
    }

    public function destroy($id)
    {
        $app = appointment::find($id);
        $app->delete();

        Session::put('message', 'Đã xóa lịch hẹn!');
        return Redirect::to('/quan-ly-lich-hen');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_code' => 'required',
            'service_quantity' => 'required|integer',
            'service_price' => 'required|integer',
        ]);

        $appointment = new Appointment;
        $appointment->appointment_code = $request->appointment_code;
        $appointment->service_quantity = $request->service_quantity;
        $appointment->service_price = $request->service_price;
        $appointment->save();

        return response()->json(['status' => 'success', 'message' => 'Thêm lịch thành công']);
    }
}

    
