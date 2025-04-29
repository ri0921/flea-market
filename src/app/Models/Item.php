<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%'. $keyword. '%');
        }
        return $query;
    }

    public function liked_by_profile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $likers = array();
        foreach($this->likes as $like) {
            array_push($likers, $like->profile_id);
        }
        if (in_array($profile->id, $likers)) {
            return true;
        } else {
            return false;
        }
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    public function getIsSoldAttribute()
    {
        return $this->purchase()->exists();
    }
}
