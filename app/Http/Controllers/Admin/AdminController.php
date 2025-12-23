<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = User::where('role', 'admin')->latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '
                            <div class="d-flex gap-2">
                                <a href="' . route('admin.admins.edit', $data->id) . '" 
                                   class="btn btn-sm btn-primary text-white px-3 py-2" 
                                   title="Edit">
                                    <i class="fa fa-edit me-1"></i>
                                </a>

                                <button onclick="showDeleteConfirm(' . $data->id . ')" 
                                        class="btn btn-sm btn-danger text-white px-3 py-2" 
                                        title="Delete">
                                    <i class="fa fa-trash me-1"></i>
                                </button>
                            </div>
                        ';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (Exception $e) {
                Log::error('Admin DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.admin.admins.index');
    }

    public function create(): View
    {
        return view('backend.admin.admins.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin'
            ]);
            return redirect()->route('admin.admins.index')->with('t-success', 'Admin created successfully.');
        } catch (Exception $e) {
            Log::error('Admin Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $admin = User::findOrFail($id);
        return view('backend.admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $admin = User::findOrFail($id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            if ($request->password) {
                $admin->password = Hash::make($request->password);
            }
            $admin->save();

            return redirect()->route('admin.admins.index')->with('t-success', 'Admin updated successfully.');
        } catch (Exception $e) {
            Log::error('Admin Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            return response()->json(['success' => true, 'message' => 'Admin deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Admin Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}
