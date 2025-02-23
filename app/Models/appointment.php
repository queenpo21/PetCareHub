<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appointment extends Model
{
    use HasFactory;
    protected $table = 'appointment';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->code)) {
                $appointment->code = 'APPOINT' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }
        });
    }
    public function customer()
    {
        return $this->belongsTo(customer::class, 'cus_id');
    }
    public static function ManageTimeSlot(){
        return self::selectRaw('timeslot, appointment_date, count(*) as count')
        ->groupBy('timeslot', 'appointment_date')->get();
    }
}
