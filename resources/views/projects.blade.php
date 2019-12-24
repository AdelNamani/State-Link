@extends('layouts.doreAdmin')
@section('styles')

@endsection
@section('content')
    <div class="container-fluid disable-text-selection">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <h1>Propositions</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">State link</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Propositions</li>
                        </ol>
                    </nav>

                </div>
                <div class="separator mb-5"></div>
            </div>
        </div>
        <div class="row">
            @foreach($projects as $project)
                <div class="col-xl-6 col-lg-4">
                    <div class="card mb-4 progress-banner">
                        <div class="card-body justify-content-between d-flex flex-row align-items-center">
                            <div>
                                <i class="@if($project->average >= 0.5) simple-icon-emotsmile @else iconsmind-Crying @endif mr-2 text-white align-text-bottom d-inline-block"></i>
                                <div>
                                    <p class="lead text-white">{{$project->title}}</p>
                                    <p class="text-small text-white">{{$project->description}}</p>
                                </div>
                            </div>

                            <div>
                                <div role="progressbar" class="progress-bar-circle progress-bar-banner position-relative"
                                     data-color="white" data-trail-color="rgba(255,255,255,0.2)" aria-valuenow="{{round($project->average * 100,0)}}"
                                     aria-valuemax="100" data-show-percent="false">
                                </div>
                                <p class="text-small text-white text-center">Pourcentage de satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')

@endsection
