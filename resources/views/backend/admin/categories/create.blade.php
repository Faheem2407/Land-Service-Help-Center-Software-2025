@extends('backend.app')
@section('title', 'নতুন ক্যাটাগরি')

@section('page-content')
<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mt-4 input-style-1">
                <label for="name">ক্যাটাগরির নাম:</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="ক্যাটাগরির নাম লিখুন" value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-danger btn-lg">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
