@extends('backend.app')
@section('title', 'নতুন খরচ যোগ করুন')

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
        <form action="{{ route('admin.costs.store') }}" method="POST">
            @csrf

            {{-- ROW --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">তারিখ <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                    @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">খরচের উৎস <span class="text-danger">*</span></label>
                    <select name="cost_source_id" class="form-select select2" required>
                        <option value="">উৎস নির্বাচন করুন</option>
                        @foreach($sources as $source)
                            <option value="{{ $source->id }}" {{ old('cost_source_id') == $source->id ? 'selected' : '' }}>
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('cost_source_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">পরিমাণ <span class="text-danger">*</span></label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" required>
                    @error('amount') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-3">
                <label class="form-label">বিবরণ</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- ACTION --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.costs.index') }}" class="btn btn-secondary me-2">বাতিল</a>
                <button type="submit" class="btn btn-primary">খরচ যোগ করুন</button>
            </div>

        </form>
    </div>
</div>

@endsection


{{-- SELECT2 STYLE --}}
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<style>
.select2-container .select2-selection--single {
    height: 38px;
    padding: 4px 10px;
}
</style>
@endpush


{{-- SELECT2 SCRIPT --}}
@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    $('.select2').select2({
        width: '100%'
    });
});
</script>
@endpush
