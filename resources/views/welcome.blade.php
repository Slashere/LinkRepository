@extends('layouts.app')

@section('content')
    <div class="container">
            @can('create-link')
                <a class="btn btn-lg btn-success my-5" href="{{ route('create_link') }}">Create Link</a>
            @endcan
            <div class="text-center col-12 card-group">
                <h2 class="">Links</h2>
                @if (count($links) > 0)
                    <section class="links">
                @include('prewelcome')
                    </section>
                @else (No Links)
                @endif
            </div>
    </div>
@endsection

