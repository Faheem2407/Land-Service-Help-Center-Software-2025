<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Privilege;

class PrivilegeController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'admin')->get();

        $modules = [
            'dashboard' => 'ড্যাশবোর্ড',
            'categories' => 'ক্যাটাগরি',
            'helpers' => 'সহায়তাকারী',
            'receivers' => 'গ্রাহক',
            'costs' => 'খরচ',
            'cost_sources' => 'খরচের উৎস',
            'reports' => 'রিপোর্ট',
            'admins' => 'অ্যাডমিন',
            'settings' => 'সেটিংস'
        ];

        $selectedUser = null;
        $privileges = [];

        if ($request->filled('user_id')) {
            $selectedUser = User::findOrFail($request->user_id);

            if ($selectedUser->privileges()->exists()) {
                $privileges = $selectedUser->privileges
                    ->pluck('actions', 'module')
                    ->map(fn($a) => json_decode($a, true))
                    ->toArray();
            }
        }

        return view('backend.admin.privileges.index', compact(
            'users',
            'modules',
            'selectedUser',
            'privileges'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        Privilege::where('user_id', $request->user_id)->delete();

        foreach ($request->modules ?? [] as $module => $actions) {
            Privilege::create([
                'user_id' => $request->user_id,
                'module' => $module,
                'actions' => json_encode($actions),
            ]);
        }

        return back()->with('t-success', 'প্রিভিলেজ সফলভাবে সংরক্ষণ হয়েছে');
    }
}
