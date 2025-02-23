<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('typeProduct')->insert([
            ['name' => 'Hạt', 'category_name' =>'Đồ ăn', 'category_id' =>'1'],
            ['name' => 'Xúc xích', 'category_name' =>'Đồ ăn', 'category_id' =>'1'],
            ['name' => 'Chuồng', 'category_name' =>'Phụ kiện', 'category_id' =>'2'],
            ['name' => 'Đồ chơi', 'category_name' =>'Giải trí', 'category_id' =>'4'],
            ['name' => 'Lược chải lông', 'category_name' =>'Vệ sinh', 'category_id' =>'3'],
            ['name' => 'Đầm cho pet', 'category_name' =>'Phụ kiện', 'category_id' =>'2'],
            ['name' => 'Pate', 'category_name' =>'Đồ ăn', 'category_id' =>'1'],
        ]);
    }
}
