<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function profiles(){
        return $this->belongsTo(Profile::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
