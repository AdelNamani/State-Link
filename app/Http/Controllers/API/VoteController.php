<?php

namespace App\Http\Controllers\API;

use App\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'choice_id' => 'required',
        ]);

        $vote = new Vote();
        $vote->user_id = Auth::id();
        $vote->choice_id = $request['choice_id'];
        $vote->save();

        return response()->json(['message'=>'success'],200);
    }
}
