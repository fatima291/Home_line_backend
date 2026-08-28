<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Coupon::orderBy('created_at', 'desc')->get());
    }

    public function show(Coupon $coupon): JsonResponse
    {
        return response()->json($coupon);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code'              => 'required|string|max:50|unique:coupons,code',
            'type'              => 'required|in:percentage,fixed',
            'value'             => 'required|numeric|min:0',
            'min_order_amount'  => 'nullable|numeric|min:0',
            'max_uses'          => 'nullable|integer|min:1',
            'is_active'         => 'boolean',
            'expires_at'        => 'nullable|date',
        ]);

        $coupon = Coupon::create($validated);

        return response()->json([
            'message' => 'تم إضافة الكوبون بنجاح',
            'coupon'  => $coupon,
        ], 201);
    }

    public function update(Request $request, Coupon $coupon): JsonResponse
    {
        $validated = $request->validate([
            'code'              => 'sometimes|string|max:50|unique:coupons,code,' . $coupon->id,
            'type'              => 'sometimes|in:percentage,fixed',
            'value'             => 'sometimes|numeric|min:0',
            'min_order_amount'  => 'nullable|numeric|min:0',
            'max_uses'          => 'nullable|integer|min:1',
            'is_active'         => 'boolean',
            'expires_at'        => 'nullable|date',
        ]);

        $coupon->update($validated);

        return response()->json([
            'message' => 'تم تعديل الكوبون بنجاح',
            'coupon'  => $coupon,
        ]);
    }

    public function destroy(Coupon $coupon): JsonResponse
    {
        $coupon->delete();
        return response()->json(['message' => 'تم حذف الكوبون بنجاح']);
    }

    public function validate_coupon(Request $request): JsonResponse
    {
        $request->validate([
            'code'         => 'required|string',
            'service_id'   => 'required|exists:services,id',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json(['message' => 'كود الخصم غير صحيح'], 404);
        }

        if ($coupon->expires_at && $coupon->expires_at < now()) {
            return response()->json(['message' => 'كود الخصم منتهي الصلاحية'], 400);
        }

        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['message' => 'تم استنفاد عدد مرات استخدام هذا الكود'], 400);
        }

        if ($request->filled('total_amount') && $request->total_amount > 0) {
            $servicePrice = (float) $request->total_amount;
        } else {
            $service = \App\Models\Service::find($request->service_id);
            $servicePrice = $service->price ?? 0;
        }

        if ($servicePrice <= 0) {
            return response()->json(['message' => 'لا يمكن تطبيق كود الخصم على هذه الخدمة حالياً'], 400);
        }

        if ($servicePrice < $coupon->min_order_amount) {
            return response()->json([
                'message' => 'هذا الكود يتطلب حد أدنى للطلب قدره ' . $coupon->min_order_amount . ' ل.س'
            ], 400);
        }

        $discount = $coupon->type === 'percentage'
            ? round($servicePrice * ($coupon->value / 100), 2)
            : min($coupon->value, $servicePrice);

        return response()->json([
            'message'         => 'تم تطبيق كود الخصم بنجاح',
            'coupon_code'     => $coupon->code,
            'discount_amount' => $discount,
            'final_price'     => $servicePrice - $discount,
        ]);
    }
}