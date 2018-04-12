@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card text-center ">
                    <div class="card-header">You need to confirm your account.</div>
                        <div class="card-body">
                        Check you email or push the button to re-request activation code!
                        <form method="post" action="{{ action('VerifyUserController@updateExpiredTime', $user->id) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-primary">
                                Send Code
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
