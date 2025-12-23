@extends('backend.app')
@section('title', 'সিস্টেম সেটিংস')
@section('page-content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div class="flex-wrap container-fluid d-flex flex-stack flex-sm-nowrap">
        <!--begin::Info-->
        <div class="flex-wrap d-flex flex-column align-items-start justify-content-center me-2">
            <!--begin::Title-->
            <h1 class="text-dark fw-bold fs-2">
                @yield('title' ?? "ড্যাশবোর্ড") <small class="text-muted fs-6 fw-normal ms-1"></small>
            </h1><br>
            <!--end::Title-->
        </div>
        <!--end::Info-->
    </div>
</div>
<!--end::Toolbar-->

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-4 card-style">
                <div class="card card-body">
                    <form method="POST" action="{{ route('system.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="title">প্রতিষ্ঠানের নাম :</label>
                                    <input type="text" placeholder="প্রতিষ্ঠানের নাম লিখুন" id="title"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ $setting->title ?? '' }}" />
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="email">প্রতিষ্ঠানের ইমেইল:</label>
                                    <input type="email" placeholder="প্রতিষ্ঠানের ইমেইল লিখুন" id="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $setting->email ?? '' }}" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="system_name">প্রতিষ্ঠানের মোবাইল:</label>
                                    <input type="text" placeholder="প্রতিষ্ঠানের মোবাইল লিখুন" id="system_name"
                                        class="form-control @error('system_name') is-invalid @enderror"
                                        name="system_name" value="{{ $setting->system_name ?? '' }}" />
                                    @error('system_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="copyright_text">প্রতিষ্ঠানের কপিরাইট টেক্সট:</label>
                                    <input type="text" placeholder="প্রতিষ্ঠানের কপিরাইট টেক্সট লিখুন" id="copyright_text"
                                        class="form-control @error('copyright_text') is-invalid @enderror"
                                        name="copyright_text" value="{{ $setting->copyright_text ?? '' }}" />
                                    @error('copyright_text')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="logo">প্রতিষ্ঠানের লোগো:</label>
                                    <input type="file" class="dropify @error('logo') is-invalid @enderror" name="logo"
                                        id="logo"
                                        data-default-file="{{ asset($setting->logo ?? 'backend/assets/images/image_placeholder.png') }}" />
                                </div>

                                @error('logo')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mt-3 col-md-6">
                                <div class="input-style-1">
                                    <label for="favicon">প্রতিষ্ঠানের ফেভিকন:</label>
                                    <input type="file" class="dropify @error('favicon') is-invalid @enderror"
                                        name="favicon" id="favicon"
                                        data-default-file="{{ asset($setting->favicon ?? 'backend/assets/images/image_placeholder.png') }}" />
                                </div>
                                @error('favicon')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3 col-12">
                            <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger me-2 btn-lg">বাতিল</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
