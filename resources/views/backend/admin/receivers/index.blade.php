@extends('backend.app')
@section('title', 'গ্রাহকের তালিকা')
@section('page-content')
<div class="toolbar" id="kt_toolbar">
    <div class="container-fluid d-flex flex-stack flex-sm-nowrap flex-wrap">
        <div class="d-flex flex-column align-items-start justify-content-center me-2 flex-wrap">
            <h1 class="text-dark fw-bold fs-2">@yield('title')</h1>
            <ul class="breadcrumb fw-semibold fs-base ps-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">হোম</a>
                </li>
                <li class="breadcrumb-item text-muted">@yield('title')</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4">

        <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-semibold">গ্রাহকের তালিকা</h5>
            <a href="{{ route('admin.receivers.create') }}" class="btn btn-primary btn-lg">নতুন গ্রাহক যোগ করুন</a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <label>তারিখ থেকে</label>
                <input type="date" id="filter_date_from" class="form-control">
            </div>
            <div class="col-md-3">
                <label>তারিখ পর্যন্ত</label>
                <input type="date" id="filter_date_to" class="form-control">
            </div>
            <div class="col-md-2">
                <label>বিভাগ</label>
                <select id="filter_category" class="form-select">
                    <option value="">সকল</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>জেলা</label>
                <select id="filter_district" class="form-select">
                    <option value="">সকল</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>উপজেলা</label>
                <select id="filter_sub_district" class="form-select">
                    <option value="">সকল</option>
                    @foreach($subDistricts as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12 mt-2">
                <button id="btn_reset_filters" class="btn btn-secondary">ফিল্টার রিসেট করুন</button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table table-bordered align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>তারিখ</th>
                        <th>ক্রমিক নং</th>
                        <th>রশিদ নং</th>
                        <th>ক্যাটেগরি</th>
                        <th>গ্রাহক</th>
                        <th>মোবাইল</th>
                        <th>গ্রাম</th>
                        <th>NID নং</th>
                        <th>সহায়তাকারী</th>
                        <th>জেলা</th>
                        <th>উপজেলা</th>
                        <th>প্রসেসিং চার্জ</th>
                        <th>অনলাইন চার্জ</th>
                        <th>মোট চার্জ</th>
                        <th>সংযুক্তি</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>
@endsection

@push('style')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.receivers.index') }}",
            data: function(d) {
                d.date_from = $('#filter_date_from').val();
                d.date_to = $('#filter_date_to').val();
                d.category_id = $('#filter_category').val();
                d.district_id = $('#filter_district').val();
                d.sub_district_id = $('#filter_sub_district').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'date', name: 'date' },
            { data: 'si_no', name: 'si_no' },
            { data: 'receipt_no', name: 'receipt_no' },
            { data: 'category', name: 'category' },
            { data: 'receiver_name', name: 'receiver_name' },
            { data: 'mobile', name: 'mobile' },
            { data: 'village', name: 'village' },
            { data: 'account_book_no', name: 'account_book_no' },
            { data: 'helper', name: 'helper' },
            { data: 'district', name: 'district' },
            { data: 'sub_district', name: 'sub_district' },
            { data: 'processing_charge', name:'processing_charge'},
            { data: 'online_charge', name:'online_charge'},
            { data: 'total_charge', name: 'total_charge' },
            { data: 'attachments', name: 'attachments', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: {
            processing: `<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>`
        }
    });

    $('#filter_date_from, #filter_date_to, #filter_category, #filter_district, #filter_sub_district').change(function() {
        table.ajax.reload();
    });

    $('#btn_reset_filters').click(function() {
        $('#filter_date_from, #filter_date_to, #filter_category, #filter_district, #filter_sub_district').val('');
        table.ajax.reload();
    });

    window.showDeleteConfirm = function(id) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: 'এই রেকর্ড স্থায়ীভাবে মুছে ফেলা হবে!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, মুছে দিন!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.receivers.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    success: function(resp) {
                        if (resp.success) {
                            toastr.success(resp.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(resp.message || 'মুছতে ব্যর্থ হয়েছে।');
                        }
                    },
                    error: function() {
                        toastr.error('কোনো সমস্যা হয়েছে।');
                    }
                });
            }
        });
    };

    window.printReceiver = function(id) {
        const url = '{{ route("admin.receivers.print", ":id") }}'.replace(':id', id);
        window.open(url, '_blank');
    };
});
</script>
@endpush
