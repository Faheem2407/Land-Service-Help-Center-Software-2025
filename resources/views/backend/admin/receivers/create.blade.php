@extends('backend.app')
@section('title', 'নতুন গ্রাহক যোগ করুন')
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
        <form action="{{ route('admin.receivers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Row 1: Date, SI No, Receipt No, Category -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="date" class="form-label">তারিখ <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="si_no" class="form-label">ক্রমিক নং</label>
                    <input type="text" id="si_no" class="form-control" value="SI-{{ time() }}" disabled>
                    <input type="hidden" name="si_no" value="SI-{{ time() }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label for="receipt_no" class="form-label">রশিদ নং</label>
                    <input type="text" id="receipt_no" class="form-control" value="RCPT-{{ time() }}" disabled>
                    <input type="hidden" name="receipt_no" value="RCPT-{{ time() }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label for="category_id" class="form-label">ক্যাটেগরি <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">ক্যাটেগরি নির্বাচন করুন</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 2: Receiver Name, Mobile, Village -->
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="receiver_name" class="form-label">গ্রাহকের নাম <span class="text-danger">*</span></label>
                    <input type="text" name="receiver_name" id="receiver_name" class="form-control" value="{{ old('receiver_name') }}" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="mobile" class="form-label">মোবাইল</label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}">
                </div>
                <div class="mb-3 col-md-4">
                    <label for="village" class="form-label">গ্রাম</label>
                    <input type="text" name="village" id="village" class="form-control" value="{{ old('village') }}">
                </div>
            </div>

            <!-- Row 3: Account Book No, District, Sub-District, Helper -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="account_book_no" class="form-label">অ্যাকাউন্ট বই নং</label>
                    <input type="text" name="account_book_no" id="account_book_no" class="form-control" value="{{ old('account_book_no') }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label for="district_id" class="form-label">জেলা</label>
                    <select name="district_id" id="district_id" class="form-select">
                        <option value="">জেলা নির্বাচন করুন</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="sub_district_id" class="form-label">উপজেলা</label>
                    <select name="sub_district_id" id="sub_district_id" class="form-select">
                        <option value="">উপজেলা নির্বাচন করুন</option>
                        @foreach($subDistricts as $sub)
                        <option value="{{ $sub->id }}" {{ old('sub_district_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="helper_id" class="form-label">সহায়তাকারী</label>
                    <select name="helper_id" id="helper_id" class="form-select">
                        <option value="">সহায়তাকারী নির্বাচন করুন</option>
                        @foreach($helpers as $helper)
                        <option value="{{ $helper->id }}" {{ old('helper_id') == $helper->id ? 'selected' : '' }}>{{ $helper->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Row 4: Processing Charge, Online Charge, Attachments -->
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="processing_charge" class="form-label">প্রসেসিং চার্জ</label>
                    <input type="number" step="0.01" name="processing_charge" id="processing_charge" class="form-control" value="{{ old('processing_charge') }}">
                </div>
                <div class="mb-3 col-md-3">
                    <label for="online_charge" class="form-label">অনলাইন চার্জ</label>
                    <input type="number" step="0.01" name="online_charge" id="online_charge" class="form-control" value="{{ old('online_charge') }}">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="attachments" class="form-label">সংযুক্তি</label>
                    <input type="file" name="attachments[]" id="attachments" class="form-control" multiple>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.receivers.index') }}" class="btn btn-secondary me-2">বাতিল</a>
                <button type="submit" class="btn btn-primary">গ্রাহক যোগ করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection
