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
        return $this->belongsTo('App\Models\Profile');
    }
    public function categories(){
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function purchase(){
        return $this->hasOne('App\Models\Purchase');
    }
}
