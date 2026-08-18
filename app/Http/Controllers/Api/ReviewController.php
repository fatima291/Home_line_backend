<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $reviews = Review::with('customer:id,full_name,avatar')
            ->where('service_id', $request->service_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $reviews->avg('rating');

        return response()->json([
            'average_rating' => $averageRating ? round($averageRating, 1) : null,
            'total_reviews'  => $reviews->count(),
            'reviews'        => $reviews,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $customer = $request->user();

        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ]);

        $booking = Booking::where('id', $validated['booking_id'])
            ->where('customer_id', $customer->id)
            ->first();

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود أو لا يخصك'], 404);
        }

        if ($booking->status !== 'completed') {
            return response()->json(['message' => 'يمكن تقييم الخدمة بعد اكتمال التنفيذ فقط'], 422);
        }

        if (Review::where('booking_id', $booking->id)->exists()) {
            return response()->json(['message' => 'تم تقييم هذا الحجز مسبقاً'], 422);
        }

        $review = Review::create([
            'customer_id' => $customer->id,
            'booking_id'  => $booking->id,
            'service_id'  => $booking->service_id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'تم إضافة التقييم بنجاح',
            'review'  => $review,
        ], 201);
    }
}