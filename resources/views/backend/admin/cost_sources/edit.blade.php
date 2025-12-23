@extends('backend.app')
@section('title', 'খরচের উৎস সম্পাদনা করুন')

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
        <form action="{{ route('admin.cost_sources.update', $source->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">উৎসের নাম <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $source->name) }}" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.cost_sources.index') }}" class="btn btn-secondary me-2">বাতিল</a>
                <button type="submit" class="btn btn-primary">উৎস হালনাগাদ করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection
