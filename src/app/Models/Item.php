<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'item_categories', 'item_id', 'category_id');
    }

    public function likes(){
        return $this->hasMany(Like::class, 'item_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'item_id');
    }

    public function purchase(){
        return $this->hasOne(Purchase::class);
    }
}
