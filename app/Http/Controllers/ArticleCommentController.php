<?php

namespace App\Http\Controllers;

use App\Models\ArticleComment;
use App\Models\ReplyComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleCommentController extends Controller
{
    function store(Request $request) {
        $request->validate([
            'comment' => 'required'
        ]);
        $request->request->add([
            'user_id' => Auth::id()
        ]);
        $comment = ArticleComment::create($request->request->all());

        return response(['data'=>$comment,'message'=>'success']);
    }

    function replyStore(Request $request) {
        $request->validate([
            'reply_comment' => 'required'
        ]);
        $request->request->add([
            'user_id' => Auth::id(),
        ]);
        $comment = ReplyComment::create($request->request->all());

        return response(['data'=>$comment,'message'=>'success']);
    }
}
