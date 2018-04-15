@extends('layouts.app')

@section('content')
    <div class="col-md-10 mx-auto">
    <h3 class="mx-auto text-center">Users</h3>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($users as $user)
            <tr>
                <th>{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->status === 0)
                        <span class="badge badge-secondary">Waiting</span>
                    @endif
                    @if ($user->status === 1)
                        <span class="badge badge-success">Active</span>
                    @endif
                </td>
                <td>
                    @if ($user->isAdmin())
                        <span class="badge badge-danger">Admin</span>
                    @elseif ($user->isEditor())
                        <span class="badge badge-primary">Editor</span>
                    @else
                        <span class="badge badge-secondary">User</span>
                    @endif
                </td>
                <td>
                    <div class="row">
                    @can('update-user', $user)
                     <a role="button" class="btn btn-success btn-space btn-sm" href="{{ route('edit_user', $user->id) }}">Edit profile</a>
                    @endcan
                    @can('delete-user')
                        <form action="{{ route('delete_user',$user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-space btn-sm">Delete</button>

                        </form>
                    @endcan
                    </div>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
        {{ $users->links() }}
    </div>
@endsection
