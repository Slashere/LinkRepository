@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update user</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ route('update_user', ['user' => $user->id]) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="col-md-4 control-label">Login</label>

                                <div class="col-md-6">
                                    <input id="login" type="text" class="form-control" name="login"
                                           value="{{ old('login', $user->login) }}" required autofocus>

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name', $user->name) }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="col-md-4 control-label">last_name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name"
                                           value="{{ old('last_name', $user->last_name) }}" required autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @can('update-user-status-and-role')
                                {{-- roles options --}}
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    <label for="role" class="col-md-4 control-label">Role</label>

                                    <div class="col-md-6">
                                        <select id="role" class="form-control" name="role" required autofocus>
                                            @foreach($roles as $id => $role)
                                                <option value="{{$id}}" @if($id == $user->role->id) selected @endif>{{$role}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('role'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                            <label for="description" class="col-md-4 control-label">Verified</label>

                            {{ Form::hidden('verified', 0) }}
                            {{ Form::checkbox('verified', 1, old('verified', $user->verified)? 'checked' : '') }}
                            @endcan
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                    <a href="{{ url('/') }}" class="btn btn-primary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection