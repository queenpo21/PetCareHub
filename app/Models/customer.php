<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Customer extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('customer', function ($builder) {
            $builder->where('role', 'customer');
        });

        static::creating(function ($users) {
                $users->code = 'KH' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        });
    }
}
?>
