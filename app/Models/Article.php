<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function views()
    {
        return $this->hasOne(ArticleView::class);
    }

    public function likes()
    {
        return $this->hasOne(ArticleLike::class);
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }
}
