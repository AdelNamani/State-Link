<?php

namespace App\Http\Controllers;

use App\Project;
use App\Proposition;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public  function propositions(){
        $user = Auth::user();
        if ($user->role == 'citizen') abort(404);
        else{
            $propositions = Proposition::all(); /** That should get only the propositions of the admin's region */
            return view('propositions',['active'=>'propositions','propositions'=>$propositions]);
        }
    }

    public  function projects(){
        $user = Auth::user();
        if ($user->role == 'citizen') abort(404);
        else{
            $projects = $user->projects;
            foreach ($projects as $project) {
                $comments = $project->comments;
                $documents = [];
                foreach ($comments as $comment) {
                    $documents['documents'][] = [
                        'id' => $comment->id,
                        'language' => 'fr',
                        'text' => $comment->content
                    ];
                }
                $documents = json_encode($documents);
                $client = new Client();
                $result = $client->request('POST', env('AZURE_ENDPOINT') . '/text/analytics/v2.1/sentiment',
                    [
                        'headers' => [
                            'Ocp-Apim-Subscription-Key' => env('AZURE_APIKEY'),
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json'
                        ],
                        'body' => $documents
                    ]);
                if ($result->getStatusCode() == 200) {
                    $documents = json_decode($result->getBody()->getContents());
                    $arr = $documents->documents;
                    $total = 0;
                    foreach ($arr as $a) {
                        $total += $a->score;
                    }
                    $project->average = count($arr) != 0 ? $total / count($arr) : 0;

                } else {
                    return response()->json(['message' => 'error! Check your internet connection.'], 200);
                }
            }
            return view('projects',['active'=>'projects','projects'=>$projects]);
        }
    }
}
