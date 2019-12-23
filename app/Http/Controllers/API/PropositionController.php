<?php

namespace App\Http\Controllers\API;

use App\Proposition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class PropositionController extends Controller
{

    /**
     * Get propositions of all towns of the wilaya of the connected user with their comments
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $user = Auth::user();
        $towns = $user->town->wilaya->towns;
        $propositions = [];
        foreach ($towns as $town){
            foreach ($town->users as $user){
                $propositions[]= $user->propositions;
            }
        }

        $propositions = collect($propositions);
        foreach ($propositions as $proposition){
            $proposition->load('comments');
        }
        $propositions->sortBy('created_at');

        return response()->json(['data'=>$propositions],200);
    }


    /**
     * @param Request $request
     * Store a proposition
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){
        $request->validate([
            'content' => 'min:3|max:3000'
        ]);

        $proposition = new Proposition();
        $proposition->content = $request['content'];
        $proposition->user_id = Auth::id();

        $client = new Client();
        $result = $client->post(env('AZURE_ENDPOINT').'/text/analytics/v2.1/keyPhrases', [
            'form_params' => [
                'sample-form-data' => 'value'
            ]
        ]);
        $proposition->category_id = null; //TODO:AZ
        $proposition->save();
        return response()->json(['message'=>'success'],200);
    }
}
