<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = Inquiry::with(['vehicle', 'user'])->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show(Inquiry $inquiry)
    {
        $inquiry->load(['vehicle', 'user']);
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'status' => 'required|in:pending,responded,closed,cancelled',
        ]);

        $inquiry->update(['status' => $request->status]);

        return redirect()->route('admin.inquiries.show', $inquiry)->with('success', 'Inquiry status updated successfully.');
    }
}
