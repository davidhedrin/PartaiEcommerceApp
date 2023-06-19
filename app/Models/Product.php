<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\ImageProduct;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function image(){
        return $this->hasOne(ImageProduct::class);
    }

    public function category(){
        
        return $this->belongsTo(Category::class, 'category_id');
    }
}
