<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index(){
        $projects = [];
        $surveys = [];

        $user = Auth::user();
        $wilaya = $user->town->wilaya;
        $towns = $wilaya->towns;

        foreach ($towns as $town){
            $admin = $town->admin;
            foreach ($admin->projects as $project){
                $projects[] = $project;
            }
            foreach ($admin->surveys as $survey){
                $survey->load('choices');
                $surveys[] = $survey;
            }
        }

        $surveys = collect($surveys);
        $projects = collect($projects);

        $projects->map(function($project,$key){
            $project['type'] = 'project';
        });

        $surveys->map(function($survey,$key){
            $survey['type'] = 'survey';
        });

        $projects_surveys = $projects->merge($surveys);

//        $data = ['projects'=>$projects,'surveys'=>$surveys];
        $data = ['projects_surveys' => $projects_surveys];
        $message = 'success';

        return response()->json(['data'=>$data,'message'=>$message],200);
    }
}
