<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(Profile::class, 'reviewer_id');
    }

    public function reviewee()
    {
        return $this->belongsTo(Profile::class, 'reviewee_id');
    }
}
