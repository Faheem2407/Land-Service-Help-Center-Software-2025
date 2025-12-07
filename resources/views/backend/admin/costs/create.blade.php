@extends('backend.app')
@section('title', 'নতুন খরচ যোগ করুন')

@section('page-content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-sm-nowrap flex-wrap">
        <div class="d-flex flex-column align-items-start justify-content-center me-2 flex-wrap">
            <h1 class="text-dark fw-bold fs-2">@yield('title')</h1>
            <ul class="breadcrumb fw-semibold fs-base ps-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">হোম</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.costs.index') }}" class="text-muted text-hover-primary">খরচ</a>
                </li>
                <li class="breadcrumb-item text-muted">@yield('title')</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.costs.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="date" class="form-label">তারিখ <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}" required>
                    @error('date')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4">
                    <label for="cost_source_id" class="form-label">খরচের উৎস <span class="text-danger">*</span></label>
                    <select name="cost_source_id" id="cost_source_id" class="form-select" required>
                        <option value="">উৎস নির্বাচন করুন</option>
                        @foreach($sources as $source)
                            <option value="{{ $source->id }}" {{ old('cost_source_id') == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_source_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div class="col-md-4">
                    <label for="amount" class="form-label">পরিমাণ <span class="text-danger">*</span></label>
                    <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required>
                    @error('amount')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">বিবরণ</label>
                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.costs.index') }}" class="btn btn-secondary me-2">বাতিল</a>
                <button type="submit" class="btn btn-primary">খরচ যোগ করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection
