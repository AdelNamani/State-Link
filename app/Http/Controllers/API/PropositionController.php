<?php

namespace App\Http\Controllers\API;

use App\Category;
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
        $documents =['documents' => [
            [
                'id' => 1,
                'language' => 'fr',
                'text'=>$proposition->content
            ]
        ]];
        $documents = json_encode($documents);
        //dd($documents);
        $client = new Client();
        $result = $client->request('POST',env('AZURE_ENDPOINT').'/text/analytics/v2.1/keyPhrases',
            [
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => env('AZURE_APIKEY'),
                    'Content-Type'     => 'application/json',
                    'Accept'      => 'application/json'
                ],
                'body' => $documents
        ]);
        if($result->getStatusCode() == 200){
            $documents = json_decode($result->getBody()->getContents());
            $keyPhrases = ($documents->documents[0])->keyPhrases;
            $new_keyPhrases = [];
            foreach ($keyPhrases as $k){
                if(substr($k, -1) == "s"){
                    $new_keyPhrases[] = substr_replace($k ,"",-1);
                }
            }
            $keyPhrases = array_merge($new_keyPhrases,$keyPhrases);
            $categories = Category::all();
            foreach ($categories as $category){
                $score = 0;
                $category_keywords = json_decode($category->keywords);
                foreach ($keyPhrases as $kp)
                    foreach ($category_keywords as $kd)
                        if (strtolower($kd) === strtolower($kp)) $score++;
                $category->score = $score;
            }
            $categories = $categories->toArray();
            $id = $categories[0]['id'];
            $max_score = $categories[0]['score'];
            foreach ($categories as $category){
                if($category['score'] > $max_score) {
                    $id = $category['id'];
                    $max_score = $category['score'];
                }
            }

            $proposition->category_id = $id;
            $proposition->save();
            return response()->json(['message'=>'success'],200);
        }else{
            return response()->json(['message'=>'error! Check your internet connection.'],200);
        }
    }
}
