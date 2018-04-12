@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="large-12 columns">
                <h2>Images:</h2>
                <div id="lightgallery" class="links">
                        @include('links.pregallery')
                </div>
            </div>
        </div>
    </div>

@endsection

