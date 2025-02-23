<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HotelServiceController extends Controller
{
    public function index(){
        $topSales = Product::select('id', 'name', 'min_price','max_price','image', 'number_of_sale')->whereHas('typeProduct', function ($query) {
            $query->where('category_id', 4);
        })->take(4) ->get();
        return view('pages.dvkhachsan',compact('topSales'));
    }
}
