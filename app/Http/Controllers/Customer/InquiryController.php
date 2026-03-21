<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $inquiries = \App\Models\Inquiry::where('user_id', $customer->id)->orderBy('created_at', 'desc')->get();
        return view('customer.inquiries', compact('customer', 'inquiries'));
    }

    public function cancel($id)
    {
        $customer = Auth::guard('customer')->user();
        $inquiry = \App\Models\Inquiry::where('id', $id)->where('user_id', $customer->id)->firstOrFail();
        if (in_array($inquiry->status, ['pending', 'responded'])) {
            $inquiry->status = 'cancelled';
            $inquiry->save();
            return redirect()->route('customer.inquiries')->with('success', 'Inquiry cancelled successfully.');
        }
        return redirect()->route('customer.inquiries')->with('error', 'Unable to cancel this inquiry.');
    }
}
