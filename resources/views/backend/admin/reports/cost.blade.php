@extends('backend.app')
@section('title', 'খরচ রিপোর্ট')

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

        {{-- FILTER FORM --}}
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">শুরুর তারিখ</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">শেষের তারিখ</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">খরচ উৎস</label>
                <select name="cost_source_id" class="form-select select2">
                    <option value="">সব উৎস</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->id }}" {{ request('cost_source_id') == $source->id ? 'selected' : '' }}>
                            {{ $source->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary me-2">ফিল্টার</button>
                <a href="{{ route('admin.reports.cost') }}" class="btn btn-secondary">রিসেট</a>
            </div>
        </form>

        {{-- COST TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>তারিখ</th>
                        <th>খরচ উৎস</th>
                        <th>বিবরণ</th>
                        <th class="text-end">পরিমাণ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($costs as $index => $c)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->date)->format('Y-m-d') }}</td>
                            <td>{{ $c->source?->name }}</td>
                            <td>{{ $c->description }}</td>
                            <td class="text-end">{{ number_format($c->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">কোনো তথ্য পাওয়া যায়নি</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">মোট খরচ:</th>
                        <th class="text-end">{{ number_format($totalCost, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

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
