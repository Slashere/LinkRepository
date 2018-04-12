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
                            <!-- Delete should be a button -->
                                {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['delete_user', $user->id],
                                        'onsubmit' => "return confirm('Are you sure you want to delete?')",
                                    ]) !!}
                                {!! Form::submit('Delete',['class' => 'btn btn-small btn-danger']) !!}
                                {!! Form::close() !!}
                            <!-- End Delete button -->
                            @endcan
                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
