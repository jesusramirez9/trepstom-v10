<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'body', 'excerpt', 'image_path', 'published', 'subcategory_id', 'published_at', 'user_id'];

    protected function image() :Attribute {
        return Attribute::make(
          get: fn() => Storage::url($this->image_path)
        );
    }

    // public function subcategory(){
    //     return $this->belongsTo(Post::class);
    // }
      // RELACION UNO A MUCHOS INVERSA

        public function subcategory(){
            return $this->belongsTo(Subcategory::class);
        }
    
    // relacion uno a muchos inversa

    public function user(){
        return $this->belongsTo(User::class);
    }

    // relacion muchos a muchos polimorficas

    public function tags(){
        return $this->morphToMany(Tag::class, 'taggable');
    }

    
    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }


}
