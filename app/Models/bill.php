<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class bill extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'id', 'user_id','updated_at', 'total','status'   
    ];

}
