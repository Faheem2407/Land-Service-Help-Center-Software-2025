@extends('backend.app')
@section('title', 'গ্রাহক সম্পাদনা করুন')
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
                    <a href="{{ route('admin.receivers.index') }}" class="text-muted text-hover-primary">গ্রাহক</a>
                </li>
                <li class="breadcrumb-item text-muted">@yield('title')</li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.receivers.update', $receiver->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <!-- Row 1: Date, SI No, Receipt No, Category -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label class="form-label">তারিখ <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $receiver->date) }}" required>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">ক্রমিক নং</label>
                    <input type="text" class="form-control" value="{{ $receiver->si_no }}" disabled>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">রশিদ নং</label>
                    <input type="text" class="form-control" value="{{ $receiver->receipt_no }}" disabled>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">ক্যাটেগরি <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select" required>
                        <option value="">ক্যাটেগরি নির্বাচন করুন</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $receiver->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Receiver Name, Mobile, Village -->
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">গ্রাহকের নাম <span class="text-danger">*</span></label>
                    <input type="text" name="receiver_name" class="form-control" value="{{ old('receiver_name', $receiver->receiver_name) }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">মোবাইল</label>
                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $receiver->mobile) }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">গ্রাম</label>
                    <input type="text" name="village" class="form-control" value="{{ old('village', $receiver->village) }}">
                </div>
            </div>

            <!-- Row 3: Account Book No, District, Sub-District, Helper -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label class="form-label">অ্যাকাউন্ট বই নং</label>
                    <input type="text" name="account_book_no" class="form-control" value="{{ old('account_book_no', $receiver->account_book_no) }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">জেলা</label>
                    <select name="district_id" class="form-select">
                        <option value="">জেলা নির্বাচন করুন</option>
                        @foreach($districts as $d)
                            <option value="{{ $d->id }}" {{ old('district_id', $receiver->district_id) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">উপজেলা</label>
                    <select name="sub_district_id" class="form-select">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        @foreach($subDistricts as $sd)
                            <option value="{{ $sd->id }}" {{ old('sub_district_id', $receiver->sub_district_id) == $sd->id ? 'selected' : '' }}>{{ $sd->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">সহায়তাকারী</label>
                    <select name="helper_id" class="form-select">
                        <option value="">সহায়তাকারী নির্বাচন করুন</option>
                        @foreach($helpers as $h)
                            <option value="{{ $h->id }}" {{ old('helper_id', $receiver->helper_id) == $h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 4: Processing Charge, Online Charge, Attachments -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label class="form-label">প্রসেসিং চার্জ</label>
                    <input type="number" step="0.01" name="processing_charge" class="form-control" value="{{ old('processing_charge', $receiver->processing_charge) }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">অনলাইন চার্জ</label>
                    <input type="number" step="0.01" name="online_charge" class="form-control" value="{{ old('online_charge', $receiver->online_charge) }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">নতুন সংযুক্তি যোগ করুন</label>
                    <input type="file" name="attachments[]" class="form-control" multiple>
                </div>
            </div>

            <!-- Current Attachments -->
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

            <!-- Form Actions -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.receivers.index') }}" class="btn btn-secondary">বাতিল</a>
                <button type="submit" class="btn btn-primary">গ্রাহক আপডেট করুন</button>
            </div>
        </form>
    </div>
</div>

@push('script')
<script>
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
