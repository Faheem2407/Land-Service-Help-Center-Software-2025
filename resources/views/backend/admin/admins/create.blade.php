@extends('backend.app')
@section('title', 'নতুন অ্যাডমিন')

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
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf

            <div class="mt-4 input-style-1">
                <label>নাম:</label>
                <input type="text" name="name" placeholder="অ্যাডমিনের নাম লিখুন" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4 input-style-1">
                <label>ইমেইল:</label>
                <input type="email" name="email" placeholder="ইমেইল লিখুন" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4 input-style-1">
                <label>পাসওয়ার্ড:</label>
                <input type="password" name="password" placeholder="পাসওয়ার্ড লিখুন" class="form-control @error('password') is-invalid @enderror">
                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4 input-style-1">
                <label>পাসওয়ার্ড নিশ্চিত করুন:</label>
                <input type="password" name="password_confirmation" placeholder="পাসওয়ার্ড আবার লিখুন" class="form-control">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-danger btn-lg">বাতিল</a>
            </div>
        </form>
    </div>
</div>
@endsection
