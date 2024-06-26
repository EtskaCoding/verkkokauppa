<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'payment_method',
        'price',
        'paid',
        'paid_at'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }

    public function products()
    {
        $this->hasMany(UserProducts::class);
    }
}
