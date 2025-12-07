<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receiver;
use App\Models\ReceiverFile;
use App\Models\Category;
use App\Models\SystemSetting;
use App\Models\Helper;
use App\Models\District;
use App\Models\SubDistrict;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class ReceiverController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            try {
                $query = Receiver::with(['category', 'helper', 'district', 'subDistrict', 'files'])->latest();

                if ($request->filled('date_from')) {
                    $query->whereDate('date', '>=', $request->date_from);
                }
                if ($request->filled('date_to')) {
                    $query->whereDate('date', '<=', $request->date_to);
                }
                if ($request->filled('category_id')) {
                    $query->where('category_id', $request->category_id);
                }
                if ($request->filled('district_id')) {
                    $query->where('district_id', $request->district_id);
                }
                if ($request->filled('sub_district_id')) {
                    $query->where('sub_district_id', $request->sub_district_id);
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('category', fn($r) => $r->category?->name)
                    ->addColumn('helper', fn($r) => $r->helper?->name)
                    ->addColumn('district', fn($r) => $r->district?->name)
                    ->addColumn('sub_district', fn($r) => $r->subDistrict?->name)
                    ->addColumn('attachments', function($r) {
                        if($r->files->isNotEmpty()) {
                            $output = '<ul class="mb-0">';
                            foreach($r->files as $file) {
                                $output .= "<li><a href='".asset('storage/' . $file->file_path)."' target='_blank'>View</a></li>";
                            }
                            $output .= '</ul>';
                            return $output;
                        }
                        return '-';
                    })
                    ->addColumn('action', function ($receiver) {
                        return '
                            <div class="btn-group btn-group-sm">
                                <a href="'.route('admin.receivers.edit', $receiver->id).'" class="btn btn-primary text-white"><i class="fa fa-edit"></i></a>
                                <button onclick="showDeleteConfirm('.$receiver->id.')" class="btn btn-danger text-white"><i class="fa fa-trash"></i></button>
                                <button onclick="printReceiver('.$receiver->id.')" class="btn btn-info"><i class="fa fa-print"></i></button>
                            </div>';
                    })
                    ->rawColumns(['action','attachments'])
                    ->make(true);

            } catch (Exception $e) {
                Log::error('Receiver DataTable Error: '.$e->getMessage());
                return response()->json(['error' => 'Server error'], 500);
            }
        }

        $categories = Category::all();
        $districts = District::all();
        $subDistricts = SubDistrict::all();

        return view('backend.admin.receivers.index', compact('categories', 'districts', 'subDistricts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $helpers = Helper::all();
        $districts = District::all();
        $subDistricts = SubDistrict::all();
        return view('backend.admin.receivers.create', compact('categories', 'helpers', 'districts', 'subDistricts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'receiver_name' => 'required|string',
            'mobile' => 'nullable|string',
            'village' => 'nullable|string',
            'account_book_no' => 'nullable|string',
            'district_id' => 'nullable|exists:districts,id',
            'sub_district_id' => 'nullable|exists:sub_districts,id',
            'helper_id' => 'nullable|exists:helpers,id',
            'processing_charge' => 'nullable|numeric',
            'online_charge' => 'nullable|numeric',
            'attachments.*' => 'nullable|file',
        ]);

        try {
            $receiver = Receiver::create([
                'date' => $request->date,
                'si_no' => 'SI-'.time(),
                'receipt_no' => 'RCPT-'.time(),
                'category_id' => $request->category_id,
                'receiver_name' => $request->receiver_name,
                'mobile' => $request->mobile,
                'village' => $request->village,
                'account_book_no' => $request->account_book_no,
                'district_id' => $request->district_id,
                'sub_district_id' => $request->sub_district_id,
                'helper_id' => $request->helper_id,
                'processing_charge' => $request->processing_charge ?? 0,
                'online_charge' => $request->online_charge ?? 0,
                'total_charge' => ($request->processing_charge ?? 0) + ($request->online_charge ?? 0),
            ]);

            Transaction::updateOrCreate(['receiver_id' => $receiver->id, 'type' => 'processing'], ['amount' => $receiver->processing_charge]);
            Transaction::updateOrCreate(['receiver_id' => $receiver->id, 'type' => 'online'], ['amount' => $receiver->online_charge]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $receiver->files()->create(['file_path' => $file->store('receivers', 'public')]);
                }
            }

            return redirect()->route('admin.receivers.index')->with('t-success','Receiver added successfully.');
        } catch (Exception $e) {
            Log::error('Receiver Store Error: '.$e->getMessage());
            return redirect()->back()->with('t-error','Something went wrong.');
        }
    }

    public function edit(int $id): View
    {
        $receiver = Receiver::findOrFail($id);
        $categories = Category::all();
        $helpers = Helper::all();
        $districts = District::all();
        $subDistricts = SubDistrict::all();
        return view('backend.admin.receivers.edit', compact('receiver','categories','helpers','districts','subDistricts'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'receiver_name' => 'required|string',
            'mobile' => 'nullable|string',
            'village' => 'nullable|string',
            'account_book_no' => 'nullable|string',
            'district_id' => 'nullable|exists:districts,id',
            'sub_district_id' => 'nullable|exists:sub_districts,id',
            'helper_id' => 'nullable|exists:helpers,id',
            'processing_charge' => 'nullable|numeric',
            'online_charge' => 'nullable|numeric',
            'attachments.*' => 'nullable|file',
        ]);

        try {
            $receiver = Receiver::findOrFail($id);
            $receiver->update([
                'date' => $request->date,
                'category_id' => $request->category_id,
                'receiver_name' => $request->receiver_name,
                'mobile' => $request->mobile,
                'village' => $request->village,
                'account_book_no' => $request->account_book_no,
                'district_id' => $request->district_id,
                'sub_district_id' => $request->sub_district_id,
                'helper_id' => $request->helper_id,
                'processing_charge' => $request->processing_charge ?? 0,
                'online_charge' => $request->online_charge ?? 0,
                'total_charge' => ($request->processing_charge ?? 0) + ($request->online_charge ?? 0),
            ]);

            Transaction::updateOrCreate(['receiver_id' => $receiver->id, 'type' => 'processing'], ['amount' => $receiver->processing_charge]);
            Transaction::updateOrCreate(['receiver_id' => $receiver->id, 'type' => 'online'], ['amount' => $receiver->online_charge]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $receiver->files()->create(['file_path' => $file->store('receivers', 'public')]);
                }
            }

            return redirect()->route('admin.receivers.index')->with('t-success','Receiver updated successfully.');
        } catch (Exception $e) {
            Log::error('Receiver Update Error: '.$e->getMessage());
            return redirect()->back()->with('t-error','Update failed.');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $receiver = Receiver::findOrFail($id);
            $receiver->transactions()->delete();
            $receiver->delete();
            return response()->json(['success'=>true,'message'=>'Receiver deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Receiver Delete Error: '.$e->getMessage());
            return response()->json(['success'=>false,'message'=>'Delete failed.'],500);
        }
    }

    public function deleteFile(Request $request): JsonResponse
    {
        $file = ReceiverFile::findOrFail($request->file_id);
        if ($file->receiver_id == $request->receiver_id) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false],403);
    }

    public function print(Receiver $receiver): View
    {
        $receiver->load(['category','helper','district','subDistrict','files']);

        $logoPath = SystemSetting::first()?->logo ?? null;

        $logo = $logoPath 
            ? asset($logoPath)
            : asset('images/default-udc-logo.png');

        return view('backend.admin.receivers.print', compact('receiver','logo'));
    }
}
