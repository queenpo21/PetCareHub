<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = 'orderdetail';
    protected $fillable = ['order_id', 'product_id', 'num', 'size', 'price', 'rating','created_at','updated_at'];

    public $timestamps = false;
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function calculateTotalSoldByProductId($productId)
    {
        $totalSold = OrderDetail::where('product_id', $productId)->sum('num');

        return $totalSold;
    }

    public static function calculateAverageRating($productId)
    {
        return self::where('product_id', $productId)->avg('rating');
    }
    public static function calculateNumOfSale($productId)
    {
        return self::where('product_id', $productId)->sum('num');
    }

    public static function calculateNumRating($productId)
    {
        return self::where('product_id', $productId)->whereNotNull('rating')->count();
    }

    protected static function booted()
    {
        static::created(function ($orderDetail) {
            self::updateProductRatingAndSales($orderDetail);
        });

        static::updated(function ($orderDetail) {
            self::updateProductRatingAndSales($orderDetail);
        });

        static::deleted(function ($orderDetail) {
            self::updateProductRatingAndSales($orderDetail);
        });
    }

    protected static function updateProductRatingAndSales($orderDetail)
    {
        // Lấy thông tin sản phẩm từ chi tiết đơn hàng
        $productId = $orderDetail->product_id;

        // Cập nhật trường rating và số lượng bán hàng của sản phẩm tương ứng trong bảng Product
        $product = Product::find($productId);
        if ($product) {
            // Cập nhật trường rating và số lượng bán hàng của sản phẩm
            $product->updateAverageRating();
            $product->updateNumOfSale();
        }
    }
}
