<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_fname', 'user_lname', 'user_phone', 'user_address', 'zip_code', 'quantity', 'total'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return strtoupper("{$this->user_fname} {$this->user_lname}");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->user_id = \Auth::id();
        });
    }
}
