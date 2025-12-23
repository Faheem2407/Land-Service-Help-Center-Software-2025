@extends('backend.app')
@section('title', 'গ্রাহকের তালিকা')

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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-semibold mb-0">গ্রাহকের তালিকা</h5>
            <a href="{{ route('admin.receivers.create') }}" class="btn btn-primary btn-lg">
                নতুন গ্রাহক যোগ করুন
            </a>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <label class="form-label">তারিখ থেকে</label>
                <input type="date" id="filter_date_from" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">তারিখ পর্যন্ত</label>
                <input type="date" id="filter_date_to" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">ক্যাটেগরি</label>
                <select id="filter_category" class="form-select select2">
                    <option value="">সকল ক্যাটেগরি</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">জেলা</label>
                <select id="filter_district" class="form-select select2">
                    <option value="">সকল জেলা</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}">{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">উপজেলা</label>
                <select id="filter_sub_district" class="form-select select2">
                    <option value="">সকল উপজেলা</option>
                    @foreach($subDistricts as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-12">
                <button id="btn_reset_filters" class="btn btn-secondary btn-sm">ফিল্টার রিসেট করুন</button>
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
                        <th>নাম</th>
                        <th>মোবাইল</th>
                        <th>গ্রাম</th>
                        <th>মৌজা</th>
                        <th>খতিয়ান নং</th>
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
<link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>
    .select2-container .select2-selection--single { height: 38px !important; padding: 4px 10px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 30px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; }
</style>
@endpush

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%' });

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        scrollCollapse: true,
        fixedHeader: true,
        fixedColumns: { left: 1, right: 1 },
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
            { data: 'DT_RowIndex', orderable: false, searchable: false, width: "50px" },
            { data: 'date', width: "100px" },
            { data: 'si_no', width: "130px" },
            { data: 'receipt_no', width: "130px" },
            { data: 'category' },
            { data: 'receiver_name' },
            { data: 'mobile' },
            { data: 'village' },
            { data: 'mouza_name' },
            { data: 'khatian_no' },
            { data: 'helper' },
            { data: 'district' },
            { data: 'sub_district' },
            { data: 'processing_charge', className: 'text-end' },
            { data: 'online_charge', className: 'text-end' },
            { data: 'total_charge', className: 'text-end' },
            { data: 'attachments', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false, width: "100px" }
        ],
        order: [[1, 'desc']]
    });

    $('#filter_date_from, #filter_date_to, #filter_category, #filter_district, #filter_sub_district').on('change', function() {
        table.ajax.reload();
    });

    $('#btn_reset_filters').on('click', function() {
        $('#filter_date_from, #filter_date_to').val('');
        $('#filter_category, #filter_district, #filter_sub_district').val('').trigger('change');
        table.ajax.reload();
    });

    window.showDeleteConfirm = function(id) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এই গ্রাহকের তথ্য স্থায়ীভাবে মুছে যাবে!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'হ্যাঁ, মুছে ফেলুন',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/receivers/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.success) {
                            table.ajax.reload(null, false);
                            toastr.success(res.message || 'সফলভাবে মুছে ফেলা হয়েছে');
                        }
                    },
                    error: function() {
                        toastr.error('মুছে ফেলতে ব্যর্থ হয়েছে');
                    }
                });
            }
        });
    };
});
</script>
@endpush
