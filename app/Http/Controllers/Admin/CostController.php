<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\CostSource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class CostController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = Cost::with('source')->latest();

                if ($request->filled('date_from') && $request->filled('date_to')) {
                    $query->whereBetween('date', [$request->date_from, $request->date_to]);
                }

                if ($request->filled('cost_source_id')) {
                    $query->where('cost_source_id', $request->cost_source_id);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('cost_source', fn($cost) => $cost->source?->name) 
                    ->addColumn('description', fn($cost) => $cost->description ?: '-') 
                    ->addColumn('amount', fn($cost) => number_format($cost->amount, 2))
                    ->editColumn('date', function ($row) {
                        return $row->date ? Carbon::parse($row->date)->format('Y-m-d') : '';
                    })
                    ->addColumn('action', function ($data) {
                        return '
                            <div class="d-flex gap-2">
                                <a href="' . route('admin.costs.edit', $data->id) . '" 
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
                Log::error('Cost DataTable Error: ' . $e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        $sources = CostSource::all();
        return view('backend.admin.costs.index', compact('sources'));
    }

    public function create(): View
    {
        $sources = CostSource::all();
        return view('backend.admin.costs.create', compact('sources'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'cost_source_id' => 'required|exists:cost_sources,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            Cost::create($request->all());
            return redirect()->route('admin.costs.index')->with('t-success', 'Cost added successfully.');
        } catch (Exception $e) {
            Log::error('Cost Store Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $cost = Cost::findOrFail($id);
        $sources = CostSource::all();
        return view('backend.admin.costs.edit', compact('cost', 'sources'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'cost_source_id' => 'required|exists:cost_sources,id',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $cost = Cost::findOrFail($id);
            $cost->update($request->all());
            return redirect()->route('admin.costs.index')->with('t-success', 'Cost updated successfully.');
        } catch (Exception $e) {
            Log::error('Cost Update Error: ' . $e->getMessage());
            return redirect()->back()->with('t-error', 'Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $cost = Cost::findOrFail($id);
            $cost->delete();
            return response()->json(['success' => true, 'message' => 'Cost deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Cost Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed.'], 500);
        }
    }
}
