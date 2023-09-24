<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'file',
        'created_by',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id')->orderBy('comments', 'DESC')->paginate(2);
    }
}