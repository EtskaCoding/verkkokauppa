<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'due_date',
        'product_id',
        'payment_method',
        'price',
        'paid',
        'paid_at',
        'uuid'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function products()
    {
        $this->hasMany(UserProducts::class);
    }

    public function paypalToken() {
        $this->hasMany(PaypalTokens::class);
    }
}
