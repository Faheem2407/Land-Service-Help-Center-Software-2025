<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Receiver;
use App\Models\Category;
use App\Models\Helper;
use App\Models\District;
use App\Models\ReceiverFile;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Storage;

class ReceiverController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $query = Receiver::with(['category', 'helper', 'district', 'subDistrict', 'files'])->latest();

            if ($request->filled('date_from')) $query->whereDate('date', '>=', $request->date_from);
            if ($request->filled('date_to')) $query->whereDate('date', '<=', $request->date_to);
            if ($request->filled('category_id')) $query->where('category_id', $request->category_id);
            if ($request->filled('district_id')) $query->where('district_id', $request->district_id);
            if ($request->filled('sub_district_id')) $query->where('sub_district_id', $request->sub_district_id);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category', fn($r) => $r->category?->name ?? '-')
                ->addColumn('helper', fn($r) => $r->helper?->name ?? '-')
                ->addColumn('district', fn($r) => $r->district?->name ?? '-')
                ->addColumn('sub_district', fn($r) => $r->subDistrict?->name ?? '-')
                ->addColumn('receiver_name', fn($r) => $r->receiver_name)
                ->addColumn('mobile', fn($r) => $r->mobile ?? '-')
                ->addColumn('village', fn($r) => $r->village ?? '-')
                ->addColumn('mouza_name', fn($r) => $r->mouza_name ?? '-')
                ->addColumn('customer_info', function($r) {
                    return '<strong>' . htmlspecialchars($r->receiver_name) . '</strong><br>' .
                           ($r->mobile ? 'মোবাইল: ' . $r->mobile . '<br>' : '') .
                           ($r->village ? 'গ্রাম: ' . $r->village . '<br>' : '') .
                           ($r->mouza_name ? 'মৌজা: ' . $r->mouza_name : '');
                })
                ->addColumn('attachments', function($r) {
                    if ($r->files->isEmpty()) return '-';
                    $links = '';
                    foreach ($r->files as $file) {
                        $links .= "<a href='" . asset($file->file_path) . "' target='_blank' class='btn btn-sm btn-outline-primary me-1 mb-1'>ফাইল</a>";
                    }
                    return $links;
                })
                ->addColumn('action', function($r) {
                    return '<div class="d-flex gap-2">
                        <a href="' . route('admin.receivers.edit', $r->id) . '" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="' . route('admin.receivers.print', $r->id) . '" target="_blank" class="btn btn-sm btn-info" title="Print">
                            <i class="fa fa-print"></i>
                        </a>
                        <button onclick="showDeleteConfirm(' . $r->id . ')" class="btn btn-sm btn-danger" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['customer_info', 'attachments', 'action'])
                ->make(true);
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

        $nextId = (Receiver::max('id') ?? 0) + 1;

        $paddedId = str_pad($nextId, 12, '0', STR_PAD_LEFT);

        $si_no = $paddedId;
        $receipt_no = $paddedId;

        return view('backend.admin.receivers.create', compact(
            'categories','helpers','districts','subDistricts',
            'si_no','receipt_no'
        ));
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'receiver_name' => 'required|string',
            'mobile' => 'nullable|string',
            'village' => 'nullable|string',
            'mouza_name' => 'nullable|string',
            'khatian_no' => 'nullable|string',
            'district_id' => 'nullable|exists:districts,id',
            'sub_district_id' => 'nullable|exists:sub_districts,id',
            'helper_id' => 'nullable|exists:helpers,id',
            'processing_charge' => 'nullable|numeric',
            'online_charge' => 'nullable|numeric',
            'attachments.*' => 'nullable|file',
        ]);

        try {
            // Create receiver first
            $receiver = Receiver::create([
                'date' => $request->date,
                'category_id' => $request->category_id,
                'receiver_name' => $request->receiver_name,
                'mobile' => $request->mobile,
                'village' => $request->village,
                'mouza_name' => $request->mouza_name,
                'khatian_no' => $request->khatian_no,
                'district_id' => $request->district_id,
                'sub_district_id' => $request->sub_district_id,
                'helper_id' => $request->helper_id,
                'processing_charge' => $request->processing_charge ?? 0,
                'online_charge' => $request->online_charge ?? 0,
                'total_charge' => ($request->processing_charge ?? 0) + ($request->online_charge ?? 0),
            ]);

            $receiver->update([
                'si_no' => $request->si_no,
                'receipt_no' => $request->receipt_no,
            ]);

            // Attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {

                    $storedPath = uploadImage($file, 'receivers');

                    $receiver->files()->create([
                        'file_path' => $storedPath, 
                    ]);
                }
            }


            // Create Transactions
            $receiver->transactions()->createMany([
                ['type' => 'processing', 'amount' => $receiver->processing_charge],
                ['type' => 'online', 'amount' => $receiver->online_charge],
                ['type' => 'total', 'amount' => $receiver->total_charge],
            ]);

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
            'mouza_name' => 'nullable|string',
            'khatian_no' => 'nullable|string',
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
                'mouza_name' => $request->mouza_name,
                'khatian_no' => $request->khatian_no,
                'district_id' => $request->district_id,
                'sub_district_id' => $request->sub_district_id,
                'helper_id' => $request->helper_id,
                'processing_charge' => $request->processing_charge ?? 0,
                'online_charge' => $request->online_charge ?? 0,
                'total_charge' => ($request->processing_charge ?? 0) + ($request->online_charge ?? 0),
            ]);

            // Attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {

                    // Use uploadImage()
                    $storedPath = uploadImage($file, 'receivers');

                    $receiver->files()->create([
                        'file_path' => $storedPath,
                    ]);
                }
            }

            // Update Transactions
            foreach (['processing', 'online', 'total'] as $type) {
                $amount = match($type) {
                    'processing' => $receiver->processing_charge,
                    'online' => $receiver->online_charge,
                    'total' => $receiver->total_charge,
                };
                $transaction = $receiver->transactions()->where('type', $type)->first();
                if ($transaction) {
                    $transaction->update(['amount' => $amount]);
                } else {
                    $receiver->transactions()->create(['type' => $type, 'amount' => $amount]);
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
            $receiver->files()->delete();
            $receiver->delete();
            return response()->json(['success'=>true,'message'=>'Receiver deleted successfully.']);
        } catch (Exception $e) {
            Log::error('Receiver Delete Error: '.$e->getMessage());
            return response()->json(['success'=>false,'message'=>'Delete failed.'],500);
        }
    }

   

    public function deleteFile(Request $request): JsonResponse
    {
        $request->validate([
            'file_id' => 'required|integer|exists:receiver_files,id',
            'receiver_id' => 'required|integer|exists:receivers,id',
        ]);

        try {
            $file = ReceiverFile::where('id', $request->file_id)
                                ->where('receiver_id', $request->receiver_id)
                                ->firstOrFail();

            $fileUrl = asset($file->file_path);

            deleteImage($fileUrl); 

            $file->delete();

            return response()->json(['success' => true, 'message' => 'File deleted successfully.']);

        } catch (\Exception $e) {
            Log::error('File Delete Error: '.$e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete file.'], 500);
        }
    }


    public function print(int $id): View
    {
        $receiver = Receiver::with(['helper', 'category'])->findOrFail($id);
        return view('backend.admin.receivers.print', compact('receiver'));
    }
}
