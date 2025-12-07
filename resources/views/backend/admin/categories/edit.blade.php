@extends('backend.app')
@section('title', 'ক্যাটেগরি সম্পাদনা')

@section('page-content')
<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mt-4 input-style-1">
                <label for="name">ক্যাটেগরির নাম:</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">আপডেট করুন</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger btn-lg">বাতিল</a>
            </div>

        </form>
    </div>
</div>
@endsection
