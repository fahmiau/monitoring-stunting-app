<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function index()
    {
        $response = Article::all();

        return response($response);
    }

    public function getPublishedArticle()
    {
        $response = Article::where('published', true)->with('views')->get();

        return response($response);
    }

    public function store(Request $request)
    {
        $article = Article::create($request);
        ArticleView::create([
            'article_id' => $article->id,
            'views' => 0
        ]);

        return response(['data' => $article,'message'=> 'success']);
    }

    public function show($id)
    {
        $views = ArticleView::where('article_id',$id)->first();
        $views->views +=1;
        $views->update();

        $article = Article::find($id)->with('views','comments')->get();

        return response(['data'=>$article,'message'=>'success']);
    }

    public function update(Request $request)
    {
        $article = Article::find($request->id)->update($request->all());

        return response(['data' => $article, 'message' => 'success']);
    }
}
