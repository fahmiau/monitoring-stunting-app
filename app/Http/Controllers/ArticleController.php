<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleImage;
use App\Models\ArticleLike;
use App\Models\ArticleView;
use App\Models\ReplyComment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $response = Article::with(['views','likes' => function ($query) {
            $query->where('liked', true); // Filter likes where 'liked' is true
        }])
        ->get(['id','title','slug','author','publish_date','published']);
        return response($response);
    }

    public function getPublishedArticle()
    {
        $response = Article::where('published', 1)->with(['views','images','likes' 
            => function ($query) {
            $query->where('liked', true);}])
        ->get(['id','title','slug','excerpt','author','publish_date']);

        return response($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles',
            'body' => 'required'
        ]);

        $request->request->add([
            'user_id' => Auth::id(),
            'slug' => Str::slug($request->title,'-'),
            'excerpt' => Str::limit($request->body, 100)    
        ]);
        if ($request->published == 1){
            date_default_timezone_set('Asia/Jakarta');
            $request->request->add([
                'publish_date' => date('Y-m-d')
            ]);
        }
        $article = Article::create($request->request->all());
        ArticleView::create([
            'article_id' => $article->id,
            'views' => 0
        ]);
        // ArticleLike::create([
        //     'article_id' => $article->id,
        //     'likes' => 0
        // ]);
        if (!empty($request->image_url)) {
            ArticleImage::create([
                'article_id' => $article->id,
                'image_url' => $request->image_url,
                'image_name' => $request->image_name,
            ]);
        }
        return response(['data' => $article,'message'=> 'success']);
    }

    public function show($slug)
    {
        $article = Article::where('slug',$slug)
            ->with(['views','images','likes' 
                => function ($query) {
                $query->where('liked', true);}])
            ->first();
        $comments = ArticleComment::where('article_id',$article->id)
            ->with([
                'replies' => function ($query){
                    $query->with('user');
                },
                'user' => function ($query){
                    $query->select('id','name');
            }])
            ->get();
        $article['comments'] = $comments;
        $views = ArticleView::where('article_id',$article->id)->first();
        $views->views +=1;
        $views->update();
        $liked = false;
        if (auth('sanctum')->user()) {
            $like = ArticleLike::where([
                ['article_id','=',$article->id],
                ['user_id','=',auth('sanctum')->user()->id]])
                ->first();
        }
        if (!empty($like)) {
            $liked = $like->liked;
        }
        $article['liked'] = $liked;

        return response(['data'=>$article,'message'=>'success']);
    }

    public function showAdmin($slug)
    {
        $article = Article::where('slug',$slug)->first();

        return response($article);
    }

    public function update($slug, Request $request)
    {
        if ($request->published == 1){
            date_default_timezone_set('Asia/Jakarta');
            $request->request->add([
                'publish_date' => date('Y-m-d')
            ]);
        }
        $article_image = [
            'image_url' => $request->image_url,
            'image_name' => $request->image_name,
        ];
        $request->request->remove('image_url');
        $request->request->remove('image_name');
        $article = Article::where('slug',$slug)->first();
        $article->update($request->all());
        ArticleImage::updateOrCreate(
            ['article_id' => $article->id],
            $article_image);
        return response(['slug' => $slug, 'message' => 'success']);
    }

    public function delete($slug)
    {
        $article = Article::where('slug',$slug)->first();
        // $article_views = ArticleView::where('article_id',$article->id)->delete();
        // $article_likes = ArticleView::where('article_id',$article->id)->delete();
        if (count($article->likes) > 0){
            $article->likes->delete();
        }
        if ($article->views){
            $article->views->delete();
        }

        if (count($article->images) > 0) {
            $article->images->delete();
        }
        if (count($article->comments) > 0) {
            $article->comments->delete();
        }
        $article->delete();
        return response(['message' => 'Artikel Berhasil Dihapus']);
    }

    function articleLike(Request $request) {
        $like = ArticleLike::where('article_id',$request->article_id)
            ->where('user_id',Auth::id())
            ->first();
        if (empty($like)) {
            $like = ArticleLike::create([
                'article_id' => $request->article_id,
                'user_id' => Auth::id(),
                'likes' => true
            ]);
        }
        else {
            $like->update([
                'liked' => $like->liked ? false : true
            ]);
        }
        
        return response(['data'=>$like->liked,'message' => 'success']);
    }
}
