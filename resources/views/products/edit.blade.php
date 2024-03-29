@extends('layouts.master')

<h1>Edit Product</h1>

@if (\Session::has('msg'))
    <div class="alert alert-success">
        {{ \Session::get('msg') }}
    </div>
@endif

@section('content')
    <div class="container">
        <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">

            @csrf

            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" id="name" name="name" type="text" value="{{ $product->name }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="price">Price</label>
                <input class="form-control" id="price" name="price" type="number" value="{{ $product->price }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input class="form-control" id="img" name="img" type="file" />
                <img src="{{ \Storage::url($product->img) }}" width="100px" alt="">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ $product->description }}</textarea>
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
