<?php

namespace App\Http\Controllers\API;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request){
        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->project_id = $request['project_id'];
        $comment->content = $request['content'];
        $comment->save();
        return response()->json(['message'=>'Success! Comment saved.'],200);
    }

    public function update(Request $request){
        $comment = Comment::findOrFail($request->id);
        $comment->content = $request['content'];
        $comment->save();
        return response()->json(['message'=>'Success! Comment updated.'],200);
    }

    public function delete(Request $request){
        Comment::destroy($request->id);
        return response()->json(['message'=>'Success! Comment deleted.'],200);
    }
}
