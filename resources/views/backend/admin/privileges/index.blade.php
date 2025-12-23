@extends('backend.app')
@section('title', 'ব্যবহারকারীর প্রিভিলেজ')

@section('page-content')
<div class="container-fluid">
    <div class="card p-4">
        <form action="{{ route('admin.privileges.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label>ব্যবহারকারী নির্বাচন করুন:</label>
                <select name="user_id" class="form-control" onchange="if(this.value) { window.location='{{ route('admin.privileges.index') }}?user_id='+this.value; }">
                    <option value="">-- ব্যবহারকারী নির্বাচন করুন --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ (isset($selectedUser) && $user->id == $selectedUser->id) ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @isset($selectedUser)
            <h5 class="mb-3">সেকশন অনুমতি দিন:</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>মডিউল</th>
                        <th>অ্যাকশনস</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Internal module keys (English) => User visible names (Bangla)
                        $moduleLabels = [
                            'dashboard' => 'ড্যাশবোর্ড',
                            'categories' => 'ক্যাটাগরি',
                            'helpers' => 'সহায়তাকারী',
                            'receivers' => 'গ্রাহক',
                            'cost_sources' => 'খরচের উৎস',
                            'costs' => 'খরচ',
                            'reports' => 'রিপোর্টস',
                            'admins' => 'অ্যাডমিন',
                            'privileges' => 'প্রিভিলেজ',
                            'settings' => 'সেটিংস'
                        ];

                        // Module actions
                        $moduleActions = [
                            'dashboard' => ['view'],
                            'categories' => ['view','create','edit','delete'],
                            'helpers' => ['view','create','edit','delete'],
                            'receivers' => ['view','create','edit','delete'],
                            'cost_sources' => ['view','create','edit','delete'],
                            'costs' => ['view','create','edit','delete'],
                            'reports' => ['view'],
                            'admins' => ['view','create','edit','delete'],
                            'privileges' => ['view','edit'],
                            'settings' => ['view','edit']
                        ];

                        // Action labels
                        $actionLabels = [
                            'view' => 'দেখতে পারবে',
                            'create' => 'নতুন তৈরি করতে পারবে',
                            'edit' => 'সম্পাদনা করতে পারবে',
                            'delete' => 'মুছে ফেলতে পারবে'
                        ];
                    @endphp

                    @foreach($moduleActions as $module => $actions)
                        @php
                            $userActions = $privileges[$module] ?? [];
                        @endphp
                        <tr>
                            <td>{{ $moduleLabels[$module] ?? ucfirst($module) }}</td>
                            <td>
                                @foreach($actions as $action)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox"
                                               name="modules[{{ $module }}][]"
                                               value="{{ $action }}"
                                               id="{{ $module }}_{{ $action }}"
                                               {{ in_array($action, $userActions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $module }}_{{ $action }}">{{ $actionLabels[$action] }}</label>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endisset

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">সাবমিট</button>
            </div>
        </form>
    </div>
</div>
@endsection
