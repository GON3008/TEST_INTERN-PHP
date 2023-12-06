@extends('layouts.master')

<h1>Create Product</h1>

@if (\Session::has('msg'))
    <div class="alert alert-success">
        {{ \Session::get('msg') }}
    </div>
@endif

@section('content')
    <div class="container">
        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="price">Price</label>
                <input class="form-control" id="price" name="price" type="number">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input class="form-control" id="img" name="img" type="file" />
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="d-flex gap-3">
                <span class="pt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-info">Back</a>
                </span>
                <button class="btn btn-primary my-3" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection
