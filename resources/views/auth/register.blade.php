@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mx-auto">

                        <!-- form card login -->
                        <div class="card rounded-0">
                            <div class="card-header">
                                <h3 class="mb-0">Register</h3>
                            </div>
                            <div class="card-body">
                                <form class="form" role="form" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}
                                    <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                        <label for="login" class="col-md-4 control-label">Login</label>
                                        <input id="login" type="text" class="form-control form-control-lg rounded-0"
                                               name="login" value="{{ old('login') }}" required>

                                        @if ($errors->has('login'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                        <input id="email" type="email" class="form-control form-control-lg rounded-0"
                                               name="email"
                                               value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        <label for="name" class="col-md-4 control-label">Name</label>

                                        <input id="name" type="text" class="form-control form-control-lg rounded-0"
                                               name="name"
                                               value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last_name" class="col-md-4 control-label">Last name</label>

                                        <input id="last_name" type="text" class="form-control form-control-lg rounded-0"
                                               name="last_name"
                                               value="{{ old('last_name') }}" required>

                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="col-md-4 control-label">Password</label>

                                        <input id="password" type="password"
                                               class="form-control form-control-lg rounded-0" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" class="col-md-4 control-label">Confirm
                                            Password</label>

                                        <input id="password-confirm" type="password"
                                               class="form-control form-control-lg rounded-0"
                                               name="password_confirmation" required>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <!--/card-block-->
                        </div>
                        <!-- /form card login -->

                    </div>


                </div>
                <!--/row-->

            </div>
            <!--/col-->
        </div>
        <!--/row-->
    </div>
    <!--/container-->
@endsection
