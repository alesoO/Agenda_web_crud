<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'title',
        'body',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users() {
        return $this->belongsToMany(User::class, 'post_user');
    }

}
