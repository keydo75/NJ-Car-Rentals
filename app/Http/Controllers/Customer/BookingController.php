<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $bookings = \App\Models\Rental::where('user_id', $customer->id)->orderBy('created_at', 'desc')->get();
        return view('customer.bookings', compact('customer', 'bookings'));
    }
    public function cancel($id)
    {
        $customer = Auth::guard('customer')->user();
        $booking = \App\Models\Rental::where('id', $id)->where('user_id', $customer->id)->firstOrFail();
        if (in_array($booking->status, ['pending', 'confirmed', 'ongoing'])) {
            $booking->status = 'cancelled';
            $booking->save();
            return redirect()->route('customer.bookings')->with('success', 'Booking cancelled successfully.');
        }
        return redirect()->route('customer.bookings')->with('error', 'Unable to cancel this booking.');
    }
}
