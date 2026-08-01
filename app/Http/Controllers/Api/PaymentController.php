<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function pay(Request $request, $bookingId): JsonResponse
    {
        $booking = $request->user()->bookings()->find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود'], 404);
        }

        if ($booking->payment_status === 'paid') {
            return response()->json(['message' => 'تم دفع هذا الحجز مسبقاً'], 422);
        }

        $validated = $request->validate([
            'card_number'     => 'required|digits:16',
            'card_holder'     => 'required|string|max:255',
            'expiry_month'    => 'required|digits:2',
            'expiry_year'     => 'required|digits:2',
            'cvv'             => 'required|digits:3',
        ]);

        // محاكاة رفض البطاقة لو رقمها كله أصفار (سيناريو اختبار فشل)
        if ($validated['card_number'] === '0000000000000000') {
            return response()->json(['message' => 'فشلت عملية الدفع، تأكدي من بيانات البطاقة'], 402);
        }

        $booking->update([
            'payment_status' => 'paid',
            'payment_method' => 'online',
            'amount_paid'    => $booking->service->price,
        ]);

        return response()->json([
            'message' => 'تمت عملية الدفع بنجاح',
            'booking' => $booking,
        ]);
    }
}