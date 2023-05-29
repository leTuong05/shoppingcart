<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function favoriteProducts() {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
