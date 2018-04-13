@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mx-auto">

                        <!-- form card login -->
                        <div class="card rounded-0 text-center">
                            <div class="card-header">
                                <h3 class="mb-0">You need to confirm code</h3>
                            </div>
                            <div class="card-body ">
                                <div class="m-5">Check you email or push the button to re-request activation code!</div>
                                <form method="post"
                                      action="{{ action('VerifyUserController@updateExpiredTime', $user->id) }}">
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
        </div>
@endsection
