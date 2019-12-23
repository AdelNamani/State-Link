<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{

    /**
     * Return the feed for the authenticated user
     * Feed contains projects + survey for the user's wilaya
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = [];
        $surveys = [];

        $user = Auth::user();
        $wilaya = $user->town->wilaya;
        $towns = $wilaya->towns;

        foreach ($towns as $town) {
            $admin = $town->admin;
            foreach ($admin->projects as $project) {
                $project->load('comments');
                $projects[] = $project;
            }
            foreach ($admin->surveys as $survey) {
                $total_votes = 0;
                $survey->load('choices');
                foreach ($survey->choices as $choice) {
                    $choice->load('votes');
                    $choice->count_votes = count($choice->votes);
                    $total_votes += $choice->count_votes;
                }
                $survey->total_votes = $total_votes;
                $surveys[] = $survey;
            }
        }

        $surveys = collect($surveys);
        $projects = collect($projects);

        $projects->map(function ($project, $key) {
            $project['type'] = 'project';
        });

        $surveys->map(function ($survey, $key) {
            $survey['type'] = 'survey';
        });

        $projects_surveys = $projects->merge($surveys);

        $data = ['projects_surveys' => $projects_surveys];
        $message = 'success';

        return response()->json(['data' => $data, 'message' => $message], 200);
    }
}
