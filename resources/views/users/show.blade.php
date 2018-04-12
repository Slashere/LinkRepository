@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <h2>User:</h2>

                <div class="panel panel-default">
                    <div class="panel-heading"><p>Title: {{$user->login}}</p></div>

                    <div class="panel-body">
                        <p>Email: {{$user->email}}</p>
                        <p>Name: {{$user->name}}</p>
                        <p>last_name: {{$user->last_name}}</p>
                        <p>Role: {{$user->role->name}}</p>
                        @can('update-user', $user)
                            <a class="btn btn-small btn-success" href="{{ route('edit_user', $user->id) }}">Edit
                                profile</a>
                        @endcan
                    </div>

                </div>
                <h2>User links:</h2>
                @foreach ($links as $link)
                    <div class="panel panel-default">
                        <div class="panel-heading"><a
                                    href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a></div>
                        <div class="panel-body">
                            @if ($link->image != NULL)
                                <img src='{{'/images/'. $link->image }}' height="200" width="300" style="object-fit: contain;"/>
                            @endif
                            <p>Link: {{$link->link}}</p>
                            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
                            <p>Description: {{$link->description}}</p>
                            @can('update-link', $link)
                                <p>Private: {{$link->private}}</p>
                            @endcan
                            @can('update-link', $link)
                                <a class="btn btn-small btn-success" href="{{ route('edit_link', $link->id) }}">Edit
                                    this
                                    Link</a>
                            @endcan
                            @can('delete-link', $link)
                                    <form action="{{ route('delete_link',$link->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-space">Delete</button>

                                    </form>
                            @endcan
                        </div>

                    </div>

                @endforeach
                {{ $links->links() }}
            </div>
        </div>
    </div>
@endsection

