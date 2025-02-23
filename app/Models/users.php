<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class users extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone','email', 'role' ,'date_join'  
    ];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('admin', function ($builder) {
            $builder->where('role', '!=', 'Customer');
        });

        static::creating(function ($users) {
            if (empty($users->code)) {
                $users->code = 'EMP' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
