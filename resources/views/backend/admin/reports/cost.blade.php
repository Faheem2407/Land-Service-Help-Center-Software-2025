@extends('backend.app')
@section('title', 'খরচ রিপোর্ট')

@section('page-content')
<div class="container-fluid">
    <div class="card p-4">
        <!-- ফিল্টার ফর্ম -->
        <form method="GET" class="row g-3 mb-4">
            <!-- শুরুর তারিখ -->
            <div class="col-md-3">
                <label for="date_from" class="form-label">শুরুর তারিখ</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <!-- শেষের তারিখ -->
            <div class="col-md-3">
                <label for="date_to" class="form-label">শেষের তারিখ</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <!-- খরচ উৎস -->
            <div class="col-md-3">
                <label for="cost_source_id" class="form-label">খরচ উৎস</label>
                <select name="cost_source_id" id="cost_source_id" class="form-control">
                    <option value="">সব উৎস</option>
                    @foreach($sources as $source)
                        <option value="{{ $source->id }}" {{ request('cost_source_id') == $source->id ? 'selected' : '' }}>
                            {{ $source->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- ফিল্টার ও রিসেট বোতাম -->
            <div class="col-md-3 align-self-end">
                <button class="btn btn-primary">ফিল্টার</button>
                <a href="{{ route('admin.reports.cost') }}" class="btn btn-secondary">রিসেট</a>
            </div>
        </form>

        <!-- খরচ টেবিল -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>তারিখ</th>
                    <th>খরচ উৎস</th>
                    <th>বিবরণ</th>
                    <th>পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($costs as $index => $c)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $c->date }}</td>
                    <td>{{ $c->source?->name }}</td>
                    <td>{{ $c->description }}</td>
                    <td>{{ number_format($c->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">মোট খরচ:</th>
                    <th colspan="2">{{ number_format($totalCost, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
