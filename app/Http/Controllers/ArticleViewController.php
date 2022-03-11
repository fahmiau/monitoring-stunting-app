<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;

class ArticleViewController extends Controller
{
    public function addView($article_id)
    {
        $views = ArticleView::where('article_id',$article_id)->first();
        $views->views +=1;
        $views->update();

        return response(['message' => 'Berhasil Tambah View']);
    }
}
