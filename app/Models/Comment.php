<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment',
        'blog_id',
        'commented_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'commented_by');
    }

    public function blog()
    {
        return $this->belongsTo(blog::class, 'blog_id');
    }
}
