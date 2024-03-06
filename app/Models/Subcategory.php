<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    // RELACION UNO A MUCHOS INVERSA

    public function category(){
        return $this->belongsTo(Category::class);
    }

    
    // relacion uno a muchos

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

}
