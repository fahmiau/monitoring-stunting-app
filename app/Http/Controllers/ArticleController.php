<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function getAllArticle()
    {
        $response = Article::where('published', true)->get();

        return response($response);
    }

    public function store(Request $request)
    {
        $article = Article::create($request);
        ArticleView::create([
            'article_id' => $article->id,
            'views' => 0
        ]);

        return response(['message'=> 'Article Berhasil Disimpan']);
    }

    public function update(Request $request)
    {
        $article = Article::find($request->id)->update($request->all());

        return response($article);
    }
}
