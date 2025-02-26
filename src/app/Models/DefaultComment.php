<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultComment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
