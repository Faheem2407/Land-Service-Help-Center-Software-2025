@extends('backend.app')
@section('title', 'সকল অ্যাডমিন')

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

        <div class="d-flex justify-content-between mb-3">
            <h5 class="fw-semibold">সকল অ্যাডমিন</h5>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-lg">নতুন অ্যাডমিন যোগ করুন</a>
        </div>

        <div class="table-responsive">
            <table id="data-table" class="table table-bordered align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>নাম</th>
                        <th>ইমেইল</th>
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
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
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
        ajax: "{{ route('admin.admins.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        language: {
            processing: `<div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">লোড হচ্ছে...</span>
                </div>
            </div>`
        }
    });

    @if(session('t-success'))
        toastr.success("{{ session('t-success') }}");
        table.ajax.reload();
    @endif

    window.showDeleteConfirm = function(id) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: 'এই রেকর্ড স্থায়ীভাবে মুছে ফেলা হবে!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, মুছে দিন!',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                let url = '{{ route("admin.admins.destroy", ":id") }}'.replace(':id', id);
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function(resp) {
                        if (resp.success) {
                            toastr.success(resp.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(resp.message || 'মুছতে ব্যর্থ হয়েছে।');
                        }
                    },
                    error: function() { toastr.error('কোনো সমস্যা হয়েছে।'); }
                });
            }
        });
    }
});
</script>
@endpush
