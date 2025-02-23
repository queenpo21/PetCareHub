<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['user_id', 'total', 'status', 'name', 'email', 'phone', 'address', 'code', 'note', 'method_payment'];    

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
