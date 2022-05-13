<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function index()
    {
        $response = Article::with(['views','likes'])->get(['id','title','slug','author','publish_date','published']);

        return response($response);
    }

    public function getPublishedArticle()
    {
        $response = Article::where('published', true)->with(['views','likes'])->get(['id','title','slug','excerpt','author','publish_date']);

        return response($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles',
            'body' => 'required'
        ]);

        $request->request->add([
            'slug' => Str::slug($request->title,'-'),
            'excerpt' => Str::limit($request->body, 100)
        ]);

        $article = Article::create($request->request->all());
        ArticleView::create([
            'article_id' => $article->id,
            'views' => 0
        ]);
        ArticleLike::create([
            'article_id' => $article->id,
            'likes' => 0
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
