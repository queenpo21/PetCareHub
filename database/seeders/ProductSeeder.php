<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('product')->insert([
        //     [
        //         'name' => 'Hạt ngon cho mèo',
        //         'typeProduct_name' => 'Đồ ăn ngon',
        //         'typeProduct_id' => 1,
        //         'min_price' => 100000,
        //         'max_price' => 170000,
        //         'discount_price' => 15000,
        //         'inventory' => 100,
        //         'image' => 'storage\app\public\product_images\Hạt cho mèo siu ngon bổ dưỡng.jpg',
        //         'bestseller' => 1,
        //         'number_of_sale' => 50,
        //         'gallery' => 'public/frontend/image/detail-other-product.png,public\frontend\image\food-cat01.jpg',
        //         'pet' => 'Mèo',
        //         'description' => 'This is a sample description for Product 1',
        //     ],
            
        // ]);
    }
}
