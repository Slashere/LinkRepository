@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">

                    <div class="panel-heading"><p>Title: {{$link->title}}</p></div>

                    <div class="panel-body">
                        @if ($link->image != NULL)
                            <img src='{{'/images/'. $link->image }}' height="200" width="300" style="background-size: cover;"/>
                        @endif
                        <p>Link: {{$link->link}}</p>
                        <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
                        <p>Description: {{$link->description}}</p>
                    @can('update-link', $link)
                            <p>Private: {{$link->private}}</p>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

