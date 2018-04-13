@foreach ($links as $link)
    <div class="card text-center">
        <div class="card-header"><a href='{{ route('show_link',$link->id) }}'>Title: {{$link->title}}</a></div>
        <div class="card-body">
            @if ($link->image != NULL)
                <img src='{{'/images/'. $link->image }}' height="200" width="300" style="background-size: cover;"/>
            @endif
            <p>Link: <a href="{{$link->link}}">{{$link->link}}</a></p>
            <p>User: <a href="{{route('show_user',$link->user_id)}}">{{$link->user->name}}</a></p>
            <p>Description: {{$link->description}}</p>
            @can('update-link', $link)
                <p>Private: {{$link->private}}</p>
                    <a class="btn btn-small btn-warning btn-space" href="{{ route('edit_link', $link->id) }}">Edit</a>
                    @endcan
                    @can('delete-link', $link)
                        <form action="{{ route('delete_link',$link->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-space">Delete</button>
                        </form>
                    @endcan
        </div>
    </div>

@endforeach
