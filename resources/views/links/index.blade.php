@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h2>My links:</h2>
            @foreach ($links as $link)
                        <div class="card rounded-0">
                            <div class="card-header">
                                <a href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a>
                        </div>
                        <div class="panel-body">
                            @if ($link->image != NULL)
                                <img src='{{'/images/'. $link->image }}' height="200" width="300" style="background-size: cover;"/>
                            @endif
                            <p>Link: {{$link->link}}</p>
                            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
                            <p>Description: {{$link->description}}</p>
                            <p>Private: {{$link->private}}</p>
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
            <div class="col-md-2">
                @can('create-link')
                    <a class="btn btn-small btn-success" href="{{ route('create_link') }}">Create Link</a>
                @endcan
            </div>
        </div>
    </div>
@endsection

