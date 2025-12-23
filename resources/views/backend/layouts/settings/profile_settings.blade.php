@extends('backend.app')
@section('title', 'প্রোফাইল সেটিংস')
@section('page-content')
<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div class="flex-wrap container-fluid d-flex flex-stack flex-sm-nowrap">

        <div class="flex-wrap d-flex flex-column align-items-start justify-content-center me-2">

            <h1 class="text-dark fw-bold fs-2">
                @yield('title' ?? "ড্যাশবোর্ড") 
                <small class="text-muted fs-6 fw-normal ms-1"></small>
            </h1><br>

        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card-style settings-card-1 mb-30">
                <div class="profile-info">

                    <div class="card card-body mb-30">
                        <h4 class="mb-3">প্রোফাইল আপডেট করুন</h4>

                        <div class="profile-image">
                            <img id="profile-picture"
                                src="{{ asset(Auth::user()->avatar ?? 'backend/assets/images/profile.jpeg') }}"
                                alt="প্রোফাইল ছবি">

                            <div class="update-image">
                                <input type="file" name="profile_picture" id="profile_picture_input" style="display: none;">
                                <label for="profile_picture_input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="mt-2 icon icon-tabler icons-tabler-outline icon-tabler-cloud-up">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99c1.38 0 2.57 .811 3.128 1.986" />
                                        <path d="M19 22v-6" />
                                        <path d="M22 19l-3 -3l-3 3" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 card card-body">
                        <h4>তথ্য আপডেট করুন</h4>

                        <form method="POST" action="{{ route('update.profile') }}">
                            @csrf
                            <div class="row">

                                <div class="mt-2 col-12">
                                    <div class="input-style-1">
                                        <label for="name">ইউজার নাম</label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name" id="name"
                                            value="{{ Auth::user()->name }}"
                                            placeholder="পুরো নাম" />
                                        @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-2 col-12">
                                    <div class="input-style-1">
                                        <label for="email">ইমেইল</label>
                                        <input type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="ইমেইল" name="email" id="email"
                                            value="{{ Auth::user()->email }}" />
                                        @error('email')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4 col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="card card-body">
                        <h4>পাসওয়ার্ড পরিবর্তন করুন</h4>

                        <form method="POST" action="{{ route('update.Password') }}">
                            @csrf
                            <div class="row">

                                <div class="mt-2 col-12">
                                    <div class="input-style-1">
                                        <label for="old_password">বর্তমান পাসওয়ার্ড</label>
                                        <input type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            placeholder="বর্তমান পাসওয়ার্ড" name="old_password"
                                            id="old_password" />
                                        @error('old_password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-2 col-12">
                                    <div class="input-style-1">
                                        <label for="password">নতুন পাসওয়ার্ড</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="নতুন পাসওয়ার্ড" name="password" id="password" />
                                        @error('password')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-2 col-12">
                                    <div class="input-style-1">
                                        <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="পাসওয়ার্ড নিশ্চিত করুন"
                                            name="password_confirmation" id="password_confirmation" />
                                        @error('password_confirmation')
                                        <span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-4 col-12">
                                    <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger me-2 btn-lg">বাতিল</a>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#profile_picture_input').change(function() {
            const formData = new FormData();
            formData.append('profile_picture', $(this)[0].files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route('update.profile.picture') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        $('#profile-picture').attr('src', data.image_url);
                        toastr.success('প্রোফাইল ছবি সফলভাবে আপডেট হয়েছে');
                    } else {
                        toastr.error(data.message);
                    }
                },
                error: function() {
                    toastr.error('একটি ত্রুটি ঘটেছে');
                }
            });
        });
    });
</script>
@endpush
