@extends('backend.app')
@section('title', 'ক্যাশ বুক রিপোর্ট')

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
        <!-- ফিল্টার ফর্ম -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label for="date_from" class="form-label">শুরুর তারিখ</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">শেষের তারিখ</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3 align-self-end">
                <button class="btn btn-primary">ফিল্টার</button>
                <a href="{{ route('admin.reports.cash_book') }}" class="btn btn-secondary">রিসেট</a>
            </div>
        </form>

        <!-- আয় -->
        <h5>আয়</h5>
        <table class="table table-bordered table-striped mb-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>তারিখ</th>
                    <th>ক্রমিক নং</th>
                    <th>রসিদ নং</th>
                    <th>গ্রহীতার নাম</th>
                    <th>মোট চার্জ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenues as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->date }}</td>
                    <td>{{ $r->si_no }}</td>
                    <td>{{ $r->receipt_no }}</td>
                    <td>{{ $r->receiver_name }}</td>
                    <td>{{ number_format($r->total_charge, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end">মোট আয়:</th>
                    <th>{{ number_format($totalRevenue, 2) }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- খরচ -->
        <h5>খরচ</h5>
        <table class="table table-bordered table-striped mb-4">
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
                    <td>{{ \Carbon\Carbon::parse($c->date)->format('Y-m-d') }}</td>
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

        <!-- ব্যালেন্স -->
        <h5>ব্যালেন্স: {{ number_format($balance, 2) }}</h5>
    </div>
</div>
@endsection
