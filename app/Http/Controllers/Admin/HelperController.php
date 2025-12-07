<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Helper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class HelperController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = Helper::latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($helper) {
                        return '
                            <div class="btn-group btn-group-sm">
                                <a href="' . route('admin.helpers.edit', $helper->id) . '" 
                                   class="btn btn-primary text-white" title="Edit">
                                   <i class="fa fa-edit"></i>
                                </a>
                                <button onclick="showDeleteConfirm(' . $helper->id . ')" 
                                        class="btn btn-danger text-white" title="Delete">
                                   <i class="fa fa-trash"></i>
                                </button>
                            </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (Exception $e) {
                Log::error('Helper DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.admin.helpers.index');
    }

    public function create(): View
    {
        return view('backend.admin.helpers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:helpers,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Helper::create(['name' => $request->name]);
            return redirect()->route('admin.helpers.index')->with('t-success', 'Helper added successfully.');
        } catch (Exception $e) {
            Log::error('Helper Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $helper = Helper::findOrFail($id);
        return view('backend.admin.helpers.edit', compact('helper'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:helpers,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $helper = Helper::findOrFail($id);
            $helper->update(['name' => $request->name]);
            return redirect()->route('admin.helpers.index')->with('t-success', 'Helper updated successfully.');
        } catch (Exception $e) {
            Log::error('Helper Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $helper = Helper::findOrFail($id);
            $helper->delete();
            return response()->json(['success' => true, 'message' => 'Helper deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Helper Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}
