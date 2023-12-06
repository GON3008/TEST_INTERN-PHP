@extends('layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="align-items-center mb-4">
            <h1 class=" mb-0 text-gray-800">List</h1>

            <div class="d-flex justify-content-end gap-4">
                @auth
                    <a href="{{ route('categories.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                        Add New
                    </a>
                    <span>
                        <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Logout</button>
                        </form>
                    </span>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-info">Register</a>
                @endauth

            </div>
        </div>
    </div>



    @if (\Session::has('msg'))
        <div class="alert alert-success">
            {{ \Session::get('msg') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Create at</th>
                        <th>Update at</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                @if (auth()->check())
                                    {{ $item->price }}
                                @else
                                    Liên hệ
                                @endif
                            </td>
                            <td>
                                <img src="{{ \Storage::url($item->img) }}" alt="" width="100px">
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>

                            <td class="d-flex gap-4">
                                @if (auth()->check())
                                    <a href="{{ route('categories.edit', $item) }}" class="btn btn-info mt-2">Edit</a>

                                    <form action="{{ route('categories.destroy', $item) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger mt-2"
                                            onclick="return confirm('Có chắc xóa không?')">Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                {{ $data->links() }}
            </div>
        </div>
    </div>

    </div>
@endsection
