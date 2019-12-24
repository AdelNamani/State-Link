@extends('layouts.doreAdmin')
@section('content')
    <div class="container-fluid disable-text-selection">
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <h1>Propositions</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Propositions</li>
                        </ol>
                    </nav>

                </div>
                <div class="separator mb-5"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 list" data-check-all="checkAll">

                @foreach($propositions as $proposition)
                <div class="card d-flex flex-row mb-3">
                    <a class="d-flex" href="javascript:void(0)">
                        <img src="{{$proposition->category ? asset('img/'.$proposition->category->title.'.jfif') : ''}}" alt="Fat Rascal" class="list-thumbnail responsive border-0" />
                    </a>
                    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center">
                            <a href="avascript:void(0)" class="w-40 w-sm-100">
                                <p class="list-item-heading mb-1 truncate">{{$proposition->content}}</p>
                            </a>
                            <p class="mb-1 text-muted text-small w-15 w-sm-100">{{$proposition->user->town->name}}</p>
                            <p class="mb-1 text-muted text-small w-15 w-sm-100">{{\Carbon\Carbon::parse($proposition->created_at)->format('Y-m-d')}}</p>
                            <div class="w-15 w-sm-100">
                                <h4><span class="badge badge-pill badge-primary">{{$proposition->category ? $proposition->category->title : ''}}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


{{--                <nav class="mt-4 mb-3">--}}
{{--                    <ul class="pagination justify-content-center mb-0">--}}
{{--                        <li class="page-item ">--}}
{{--                            <a class="page-link first" href="#">--}}
{{--                                <i class="simple-icon-control-start"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item ">--}}
{{--                            <a class="page-link prev" href="#">--}}
{{--                                <i class="simple-icon-arrow-left"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item active">--}}
{{--                            <a class="page-link" href="#">1</a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item ">--}}
{{--                            <a class="page-link" href="#">2</a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item">--}}
{{--                            <a class="page-link" href="#">3</a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item ">--}}
{{--                            <a class="page-link next" href="#" aria-label="Next">--}}
{{--                                <i class="simple-icon-arrow-right"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item ">--}}
{{--                            <a class="page-link last" href="#">--}}
{{--                                <i class="simple-icon-control-end"></i>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </nav>--}}

            </div>
        </div>
    </div>
@endsection
