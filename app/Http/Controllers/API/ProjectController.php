<?php

namespace App\Http\Controllers\API;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function satisfactions()
    {
        $user = Auth::user();
        if ($user->role == 'citizen') abort(404);
        $projects = $user->projects;
        foreach ($projects as $project) {
            $comments = $project->comments;
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
                $project->average = count($arr) != 0 ? $total / count($arr) : 'No comments!';

            } else {
                return response()->json(['message' => 'error! Check your internet connection.'], 200);
            }
        }

        return response()->json(['data'=>$projects,'message'=>'success'],200);

    }
}
