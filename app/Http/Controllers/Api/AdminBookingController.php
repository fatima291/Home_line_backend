<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminBookingController extends Controller
{
    // عرض كل الحجوزات، مع إمكانية الفلترة
    public function index(Request $request): JsonResponse
    {
        $query = Booking::with(['service', 'customer'])
            ->where(function ($q) {
                $q->where('status', '!=', 'cancelled')
                ->orWhere('cancelled_by', 'admin');
            })
            ->orderBy('created_at', 'asc');

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    // تغيير حالة الحجز (تأكيد/إكمال/إلغاء)
    public function updateStatus(Request $request, $id): JsonResponse
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود'], 404);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === 'cancelled') {
            $updateData['cancelled_by'] = 'admin';
        } else {
            $updateData['cancelled_by'] = null;
        }

        $booking->update($updateData);

        $statusMessages = [
            'confirmed' => 'تم تأكيد حجزك لخدمة ' . $booking->service->name,
            'completed' => 'تم إنجاز خدمة ' . $booking->service->name . ' بنجاح، شكراً لك!',
            'cancelled' => 'تم إلغاء حجزك لخدمة ' . $booking->service->name,
        ];

        if (isset($statusMessages[$validated['status']]) && $booking->customer_id) {
            $tokens = $booking->customer->deviceTokens()->pluck('token')->toArray();
            (new \App\Services\FirebaseService())->sendToTokens(
                $tokens,
                'تحديث حالة الحجز',
                $statusMessages[$validated['status']]
            );
        }

        return response()->json([
            'message' => 'تم تحديث حالة الحجز بنجاح',
            'booking' => $booking,
        ]);
    }

    // تأكيد استلام الدفع النقدي (الإدمن فقط)
    public function confirmCashPayment($id): JsonResponse
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود'], 404);
        }

        if ($booking->payment_method !== 'cash') {
            return response()->json(['message' => 'هذا الحجز ليس دفعاً نقدياً'], 422);
        }

        if ($booking->payment_status === 'paid') {
            return response()->json(['message' => 'تم تأكيد دفع هذا الحجز مسبقاً'], 422);
        }

        $booking->update([
            'payment_status' => 'paid',
            'amount_paid'     => $booking->service->price - $booking->discount_amount,
        ]);

        $tokens = $booking->customer->deviceTokens()->pluck('token')->toArray();
        (new \App\Services\FirebaseService())->sendToTokens(
            $tokens,
            'تأكيد الدفع',
            'تم تأكيد استلام دفعتك النقدية لحجز ' . $booking->service->name
        );
        
        return response()->json([
            'message' => 'تم تأكيد استلام الدفع النقدي بنجاح',
            'booking' => $booking,
        ]);
    }
}