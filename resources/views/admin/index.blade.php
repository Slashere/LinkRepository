@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 col-md-offset-2">
                <h2>Users:</h2>
            @foreach($users as $user)
                    <div class="panel panel-default">

                        <div class="panel-heading"><p>Login: {{$user->login}}</p></div>

                        <div class="panel-body">
                            <p>Email: {{$user->email}}</p>
                            <p>Name: {{$user->name}}</p>
                            <p>Lastname: {{$user->last_name}}</p>
                            <p>Role:  {{$user->role->name}}</p>
                            @can('update-user', $user)
                                <a class="btn btn-small btn-success" href="{{ route('edit_user', $user->id) }}">Edit
                                    profile</a>
                            @endcan
                            @can('delete-user')
                                <form action="{{ route('delete_link',$user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-space">Delete</button>

                                </form>
                            @endcan
                        </div>

                    </div>
                @endforeach
                {{ $users->links() }}
            </div>

        </div>
    </div>
@endsection
