<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostSource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CostSourceController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = CostSource::latest();

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($source) {
                        return '
                            <div class="btn-group btn-group-sm">
                                <a href="' . route('admin.cost_sources.edit', $source->id) . '" 
                                   class="btn btn-primary text-white" title="Edit">
                                   <i class="fa fa-edit"></i>
                                </a>
                                <button onclick="showDeleteConfirm(' . $source->id . ')" 
                                        class="btn btn-danger text-white" title="Delete">
                                   <i class="fa fa-trash"></i>
                                </button>
                            </div>';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (Exception $e) {
                Log::error('CostSource DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.admin.cost_sources.index');
    }

    public function create(): View
    {
        return view('backend.admin.cost_sources.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cost_sources,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            CostSource::create($request->only('name'));
            return redirect()->route('admin.cost_sources.index')->with('t-success', 'Cost Source created successfully.');
        } catch (Exception $e) {
            Log::error('CostSource Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $source = CostSource::findOrFail($id);
        return view('backend.admin.cost_sources.edit', compact('source'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cost_sources,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $source = CostSource::findOrFail($id);
            $source->update($request->only('name'));
            return redirect()->route('admin.cost_sources.index')->with('t-success', 'Cost Source updated successfully.');
        } catch (Exception $e) {
            Log::error('CostSource Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $source = CostSource::findOrFail($id);
            $source->delete();
            return response()->json(['success' => true, 'message' => 'Cost Source deleted successfully.']);
        } catch (Exception $e) {
            Log::error('CostSource Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}
