<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'purchase_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'purchase_id');
    }


    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }
}
