@extends('layouts.app')

@section('title', 'Users')

@section('content')

@include('layouts.navbar')

<h1>Halaman Users</h1>

<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
    Create
</a>

<form action="{{ route('admin.users.index') }}" method="GET">

    <div class="input-group">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search username or email"
        >

        <button class="btn btn-outline-secondary" type="submit">
            Search
        </button>
    </div>

</form>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $users->firstItem() + $loop->index }}</td>

            <td>{{ $user->name }}</td>

            <td>{{ $user->email }}</td>

            <td>{{ $user->role->name }}</td>

            <td>
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="btn btn-sm btn-warning">
                    Edit Akun
                </a>

                <form action="{{ route('admin.users.destroy', $user) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Yakin hapus user ini?')">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}

@endsection