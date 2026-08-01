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
            $updateData['cancelled_by'] = null; // احتياط لو رجّع الحالة من إلغاء لشي تاني لاحقاً
        }

        $booking->update($updateData);

        return response()->json([
            'message' => 'تم تحديث حالة الحجز بنجاح',
            'booking' => $booking,
        ]);
    }
}