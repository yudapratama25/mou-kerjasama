<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "logs";

    protected $fillable = ['year_id', 'user_id', 'action'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id','name']);
    }
}
