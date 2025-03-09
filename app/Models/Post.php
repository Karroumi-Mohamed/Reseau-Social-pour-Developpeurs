<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
    ];

    protected $casts = [
        'content' => 'array', // Cast the JSON content to array
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function hashtags() {
        return $this->belongsToMany(Hashtag::class, 'hashtag_post');
    }

    // Helper method to get plain text content
    public function getPlainTextContent(): string 
    {
        if (!isset($this->content['blocks'])) {
            return '';
        }

        return collect($this->content['blocks'])
            ->filter(fn ($block) => $block['type'] === 'paragraph')
            ->map(fn ($block) => $block['data']['text'])
            ->join("\n");
    }

    // Helper method to get image URL
    public function getImageUrl(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    // Helper method to get a summary of the content
    public function getSummary(int $length = 150): string
    {
        $plainText = $this->getPlainTextContent();
        return strlen($plainText) > $length 
            ? substr($plainText, 0, $length) . '...'
            : $plainText;
    }
}

