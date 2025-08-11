<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function sender()
    {
        return $this->belongsTo(Profile::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Profile::class, 'receiver_id');
    }
}
