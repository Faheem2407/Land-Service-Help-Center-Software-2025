@extends('backend.app')
@section('title', 'গ্রাহক সম্পাদনা করুন')
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
        <form action="{{ route('admin.receivers.update', $receiver->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ROW 1 --}}
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label>তারিখ *</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $receiver->date) }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label>ক্রমিক নং</label>
                    <input type="text" class="form-control" value="{{ $receiver->si_no }}" disabled>
                </div>
                <div class="mb-3 col-md-4">
                    <label>রশিদ নং</label>
                    <input type="text" class="form-control" value="{{ $receiver->receipt_no }}" disabled>
                </div>
            </div>

            {{-- ROW 2 --}}
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label>ক্যাটেগরি *</label>
                    <select name="category_id" class="form-select select2" required>
                        <option value="">নির্বাচন করুন</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $receiver->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-4">
                    <label>গ্রাহকের নাম *</label>
                    <input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name', $receiver->receiver_name) }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label>মোবাইল</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $receiver->mobile) }}">
                </div>
            </div>

            {{-- ROW 3 --}}
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label>গ্রাম</label>
                    <input type="text" name="village" class="form-control" value="{{ old('village', $receiver->village) }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label>মৌজার নাম</label>
                    <input type="text" name="mouza_name" class="form-control" value="{{ old('mouza_name', $receiver->mouza_name) }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label>খতিয়ান নম্বর</label>
                    <input type="text" name="khatian_no" class="form-control" value="{{ old('khatian_no', $receiver->khatian_no) }}">
                </div>
            </div>

            {{-- ROW 4 --}}
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label>জেলা</label>
                    <select name="district_id" class="form-select select2">
                        <option value="">নির্বাচন করুন</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $receiver->district_id) == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-4">
                    <label>উপজেলা</label>
                    <select name="sub_district_id" class="form-select select2">
                        <option value="">নির্বাচন করুন</option>
                        @foreach($subDistricts as $sub)
                            <option value="{{ $sub->id }}" {{ old('sub_district_id', $receiver->sub_district_id) == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-4">
                    <label>সহায়তাকারী</label>
                    <select name="helper_id" class="form-select select2">
                        <option value="">নির্বাচন করুন</option>
                        @foreach($helpers as $helper)
                            <option value="{{ $helper->id }}" {{ old('helper_id', $receiver->helper_id) == $helper->id ? 'selected' : '' }}>
                                {{ $helper->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ROW 5 --}}
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label>প্রসেসিং চার্জ</label>
                    <input type="number" step="0.01" name="processing_charge" class="form-control" value="{{ old('processing_charge', $receiver->processing_charge) }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label>অনলাইন চার্জ</label>
                    <input type="number" step="0.01" name="online_charge" class="form-control" value="{{ old('online_charge', $receiver->online_charge) }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label>নতুন সংযুক্তি যোগ করুন</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>
                </div>
            </div>

            {{-- CURRENT ATTACHMENTS --}}
            @if($receiver->files->count())
            <div class="row mb-4">
                <div class="col-12">
                    <label>বর্তমান সংযুক্তি</label>
                    <div class="mt-3 d-flex flex-wrap gap-4">
                        @foreach($receiver->files as $file)
                        <div class="position-relative">
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                ফাইল {{ $loop->iteration }}
                            </a>
                            <button type="button" onclick="deleteAttachment({{ $file->id }})" class="btn btn-sm btn-danger position-absolute top-0 start-100 translate-middle">
                                ×
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- FORM ACTIONS --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.receivers.index') }}" class="btn btn-secondary">বাতিল</a>
                    <button type="submit" class="btn btn-primary">গ্রাহক আপডেট করুন</button>
                </div>
            </div>

        </form>
    </div>
</div>

@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container .select2-selection--single { height: 38px; padding: 4px 10px; }
</style>
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () { $('.select2').select2({ width: '100%' }); });

function deleteAttachment(id) {
    Swal.fire({
        title: 'ফাইলটি মুছে ফেলবেন কি?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'হ্যাঁ, মুছে দিন',
        cancelButtonText: 'বাতিল'
    }).then(result => {
        if (result.isConfirmed) {
            fetch("{{ route('admin.receivers.deleteFile') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ file_id: id, receiver_id: {{ $receiver->id }} })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    toastr.success("ফাইলটি মুছে ফেলা হয়েছে");
                    location.reload();
                } else {
                    toastr.error("মুছে ফেলা ব্যর্থ হয়েছে");
                }
            });
        }
    });
}
</script>
@endpush

@endsection
