@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-8 mx-auto">
                <h2>User:</h2>

                <div class="card rounded-0">
                    <div class="card-header"><p>Login: {{$user->login}}</p></div>

                    <div class="card-body">
                        <p>Email: {{$user->email}}</p>
                        <p>Name: {{$user->name}}</p>
                        <p>Last name: {{$user->last_name}}</p>
                        <p>Role: {{$user->role->name}}</p>
                        @can('update-user', $user)
                            <a class="btn btn-small btn-success" href="{{ route('edit_user', $user->id) }}">Edit
                                profile</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

