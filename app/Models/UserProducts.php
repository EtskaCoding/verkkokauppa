<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProducts extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id'
    ];

    public function product()
    {
        $this->hasOne(Product::class);
    }

    public function invoice()
    {
        $this->hasMany(Invoice::class);
    }

    public function user()
    {
        $this->hasOne(User::class);
    }
}
