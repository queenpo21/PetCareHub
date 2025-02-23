<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class product extends Model
{

    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'name', 'pet' ,'typeProduct_name','typeProduct_id', 'image', 'inventory', 'description'
    ];

    public function typeProduct()
    {
        return $this->belongsTo(Type_Product::class, 'typeProduct_id');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function calculateMinMaxPrice()
    {
        $minPrice = $this->sizes()->min('price');
        $maxPrice = $this->sizes()->max('price');

        $this->min_price = $minPrice;
        $this->max_price = $maxPrice;

        $this->save();
    }

    public function getPriceForSize($size)
    {
        $productSize = $this->sizes()->where('size', $size)->first();
        return $productSize ? $productSize->price : null;
    }

    public function updateAverageRating()
    {
        $averageRating = OrderDetail::calculateAverageRating($this->id);
        $this->rating = $averageRating;
        $this->save();
    }
    public function updateNumOfSale()
    {
        $Num = OrderDetail::calculateNumOfSale($this->id);
        $this->number_of_sale = $Num;
        $this->save();
    }

}
