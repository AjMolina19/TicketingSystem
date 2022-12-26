<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = ['id', 'importance', 'user_id', 'title', 'remarks', 'created_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
