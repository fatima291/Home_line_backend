<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    /**
     * دالة مساعدة لحساب سعر خدمة المناسبات
     */
    private function calculateEventsPrice(int $startTimeMinutes, int $durationHours, int $workersCount): float
    {
        // 1. تحديد الأساس حسب فترة البدء (الساعة 4 مساءً تعادل 960 دقيقة)
        $basePrice = ($startTimeMinutes >= 960) ? 25000 : 20000;

        // 2. حساب الساعات الإضافية فوق 4 ساعات (5,000 ل.س عن كل ساعة)
        $extraHoursPrice = max(0, $durationHours - 4) * 5000;

        // 3. حساب مقدمي الخدمة الإضافيين فوق 2 عمال (10,000 ل.س عن كل عامل إضافي)
        $extraWorkersPrice = max(0, $workersCount - 2) * 10000;

        return $basePrice + $extraHoursPrice + $extraWorkersPrice;
    }

    public function store(Request $request): JsonResponse
    {
        $customer = $request->user(); // العميل المسجل دخوله حالياً (من التوكن)

        $validated = $request->validate([
            'service_id'         => 'required|exists:services,id',
            'for_self'           => 'required|boolean',
            'payment_method'     => 'required|in:online,cash',
            'service_options'    => 'nullable|array',
            'service_options.*'  => 'nullable',
            'full_name'          => 'required_if:for_self,false|string|max:255',
            'phone'              => 'required_if:for_self,false|string|max:20',
            'national_id'        => 'required_if:for_self,false|string|max:20',
            'email'              => 'nullable|email|max:255',
            'city'               => 'required_if:for_self,false|string|max:255',
            'neighborhood'       => 'required_if:for_self,false|string|max:255',
            'street'             => 'required_if:for_self,false|string|max:255',
            'building_number'    => 'nullable|string|max:50',
            'map_link'           => 'nullable|string|max:500',
            'notes'              => 'nullable|string',
        ]);

        if ($validated['for_self']) {
            // الحجز لصاحب الحساب نفسه: نأخذ بياناته من جدول customers مباشرة
            $bookingData = [
                'customer_id'      => $customer->id,
                'full_name'        => $customer->full_name,
                'phone'            => $customer->phone,
                'national_id'      => $customer->national_id,
                'email'            => $customer->email,
                'city'             => $customer->city,
                'neighborhood'     => $customer->neighborhood,
                'street'           => $customer->street,
                'building_number'  => $customer->building_number,
                'map_link'         => $customer->location_link,
            ];
        } else {
            // الحجز لشخص آخر: نستخدم البيانات المكتوبة يدوياً بالفورم
            $bookingData = [
                'customer_id'      => $customer->id, // لسا مربوط بصاحب الحساب (هو يلي طلب الحجز)
                'full_name'        => $validated['full_name'],
                'phone'            => $validated['phone'],
                'national_id'      => $validated['national_id'],
                'email'            => $validated['email'] ?? null,
                'city'             => $validated['city'],
                'neighborhood'     => $validated['neighborhood'],
                'street'           => $validated['street'],
                'building_number'  => $validated['building_number'] ?? null,
                'map_link'         => $validated['map_link'] ?? null,
            ];
        }

        if ((int)$validated['service_id'] === 2 && !empty($options)) {
            $units = isset($options['units_count']) ? (int)$options['units_count'] : 1;
            
            $prices = [
                1 => 1500,
                2 => 2500,
                3 => 3500,
                4 => 4500,
                5 => 5500,
                6 => 6500,
            ];

            $options['total_price'] = $prices[$units] ?? 1500;
        }

        // تجهيز خيارات الخدمة والتأكد من السعر إذا كانت الخدمة "مناسبات" (ID: 3)
        $options = $validated['service_options'] ?? [];

        if ((int)$validated['service_id'] === 3 && !empty($options)) {
            $minutes = isset($options['start_time_minutes']) ? (int)$options['start_time_minutes'] : 600;
            $duration = isset($options['duration_hours']) ? (int)$options['duration_hours'] : 4;
            $workers = isset($options['workers']) ? (int)$options['workers'] : 2;

            // إعادة حساب السعر في السيرفر لضمان موثوقية التكلفة
            $options['total_price'] = $this->calculateEventsPrice($minutes, $duration, $workers);
        }

        // 🟢 4. معالجة وتأكيد سعر خدمة "مكافحة الحشرات" (ID: 4)
        if ((int)$validated['service_id'] === 4 && !empty($options)) {
            $packageName = $options['package'] ?? '';

            // خريطة أسعار الباقات المطابقة تماماً لصفحة HTML
            $packagePrices = [
                'غرفة واحدة'      => 1200,
                'غرفتين'          => 1800,
                'ثلاث غرف'        => 2400,
                'المنزل بالكامل'  => 3500,
            ];

            // تحديد السعر من جدول الأسعار أو الاعتماد على السعر الممرر من الفرونت إند
            if (isset($packagePrices[$packageName])) {
                $options['total_price'] = $packagePrices[$packageName];
            } elseif (isset($options['total_price']) && is_numeric($options['total_price'])) {
                $options['total_price'] = (float)$options['total_price'];
            } else {
                $options['total_price'] = 3500; // سعر افتراضي
            }
        }
        $bookingData['service_id']      = $validated['service_id'];
        $bookingData['payment_method']  = $validated['payment_method'];
        $bookingData['notes']           = $validated['notes'] ?? null;
        $bookingData['service_options'] = $options;

        $booking = Booking::create($bookingData);

        return response()->json([
            'message' => 'تم إرسال طلب الحجز بنجاح',
            'booking' => $booking,
        ], 201);
    }
    // إلغاء الحجز (بس لو pending)
    public function cancel(Request $request, $id): JsonResponse
    {
        $booking = $request->user()->bookings()->find($id);

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود'], 404);
        }

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'لا يمكن إلغاء هذا الحجز لأنه تم تأكيده بالفعل. الرجاء التواصل مع الإدارة.'
            ], 422);
        }

        $booking->update(['status' => 'cancelled', 'cancelled_by' => 'customer']);

        return response()->json([
            'message' => 'تم إلغاء الحجز بنجاح',
            'booking' => $booking,
        ]);
    }

    // تعديل الحجز (بس لو pending)
    public function update(Request $request, $id): JsonResponse
    {
        $booking = $request->user()->bookings()->find($id);

        if (!$booking) {
            return response()->json(['message' => 'الحجز غير موجود'], 404);
        }

        if ($booking->status !== 'pending') {
            return response()->json([
                'message' => 'لا يمكن تعديل هذا الحجز لأنه تم تأكيده بالفعل. الرجاء التواصل مع الإدارة.'
            ], 422);
        }

        $validated = $request->validate([
            'city'              => 'sometimes|string|max:255',
            'neighborhood'      => 'sometimes|string|max:255',
            'street'            => 'sometimes|string|max:255',
            'building_number'   => 'nullable|string|max:50',
            'map_link'          => 'nullable|string|max:500',
            'notes'             => 'nullable|string',
            'service_options'   => 'nullable|array',
            'service_options.*' => 'nullable',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'تم تعديل الحجز بنجاح',
            'booking' => $booking,
        ]);
    }
    public function myBookings(Request $request): JsonResponse
    {
        $bookings = $request->user()
            ->bookings()
            ->with('service')
            ->latest()
            ->get();

        return response()->json($bookings);
    }
}