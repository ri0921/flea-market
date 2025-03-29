<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
