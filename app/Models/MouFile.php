<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MouFile extends Model
{
    use SoftDeletes;

    protected $table = "files";

    protected $fillable = [
        'mou_id',
        'filename',
        'size'
    ];
}
