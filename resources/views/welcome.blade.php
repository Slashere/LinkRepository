@extends('layouts.app')

@section('content')
    <div class="container text-center">


            @can('create-link')
                <a class="btn btn-lg btn-success m-4" href="{{ route('create_link') }}">Create Link</a>
            @endcan
                <h2>Links</h2>
            @if (count($links) > 0)
                    <section class="links">
                @include('prewelcome')
                    </section>
                @else
                    <h1 class="text-center mt-5">No links</h1>
                @endif
    </div>
@endsection

