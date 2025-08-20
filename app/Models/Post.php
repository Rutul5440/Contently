<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class Post extends Model
{
    use HasRoles;
    protected $fillable = [
        'title', 'image', 'description', 'excerpt', 'status', 'user_id',
    ];

    public static function boot()
    {
        parent::boot();

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
