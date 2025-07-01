<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'image', 'description', 'excerpt', 'status', 'user_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($post){
            $post->slug = Str::slug($post->title);
        });

        static::updating(function ($post){
            $post->slug = Str::slug($post->title);
        });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
