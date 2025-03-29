<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function address(){
        return $this->hasMany('App\Models\Address');
    }

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function items(){
        return $this->hasMany('App\Models\Item');
    }

    public function purchases(){
        return $this->hasMany('App\Models\Purchase');
    }
}
