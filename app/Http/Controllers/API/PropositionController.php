<?php

namespace App\Http\Controllers\API;

use App\Proposition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PropositionController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'content' => 'min:3|max:3000'
        ]);

        $proposition = new Proposition();
        $proposition->content = $request['content'];
        $proposition->user_id = Auth::id();
        $proposition->category_id = null; //TODO:AZ
        $proposition->save();
        return response()->json(['message'=>'success'],200);
    }
}
