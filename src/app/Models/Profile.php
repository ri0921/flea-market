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
        return $this->belongsTo(User::class);
    }

    public function address(){
        return $this->hasMany(Address::class);
    }

    public function likes(){
        return $this->hasMany(Like::class, 'profile_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'profile_id');
    }

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function likedItems()
    {
        return $this->hasManyThrough(Item::class, Like::class, 'profile_id', 'id', 'id', 'item_id');
    }

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviewsReceived()->avg('rating') ?? 0);
    }
}
