<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = Category::query()->latest();
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '
                            <div class="d-flex gap-2">
                                <a href="' . route('admin.categories.edit', $data->id) . '" 
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
                Log::error('Category DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        return view('backend.admin.categories.index');
    }

    public function create(): View
    {
        return view('backend.admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Category::create(['name' => $request->name]);
            return redirect()->route('admin.categories.index')->with('t-success', 'Category created successfully.');
        } catch (Exception $e) {
            Log::error('Category Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $category = Category::findOrFail($id);
        return view('backend.admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $category = Category::findOrFail($id);
            $category->update(['name' => $request->name]);
            return redirect()->route('admin.categories.index')->with('t-success', 'Category updated successfully.');
        } catch (Exception $e) {
            Log::error('Category Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Category Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}
