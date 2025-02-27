<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }

    // Helper method to check if a post is liked by a user
    public static function isLikedBy($postId, $userId) {
        return static::where('post_id', $postId)
                    ->where('user_id', $userId)
                    ->exists();
    }
}
