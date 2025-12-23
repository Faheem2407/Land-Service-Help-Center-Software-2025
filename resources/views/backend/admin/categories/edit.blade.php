@extends('backend.app')
@section('title', 'ক্যাটাগরি সম্পাদনা')

@section('page-content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-sm-nowrap flex-wrap">
        <div class="d-flex flex-column align-items-start justify-content-center me-2 flex-wrap">
            <h1 class="text-dark fw-bold fs-2">@yield('title')</h1><br>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mt-4 input-style-1">
                <label for="name">ক্যাটেগরির নাম:</label>
                <input type="text" name="name" id="name" placeholder="ক্যাটাগরির নাম লিখুন"
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
