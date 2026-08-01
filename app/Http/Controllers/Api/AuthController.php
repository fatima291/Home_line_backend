<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
       $validated = $request->validate([
            'username'        => 'required|string|max:255|unique:customers,username',
            'full_name'       => 'required|string|max:255',
            
            // البريد الإلكتروني (صحيح وغير مكرر)
            'email'           => 'required|email:rfc,dns|max:255|unique:customers,email',
            
            // كلمة السر: 8 خانات على الأقل، وتضم أحرف كبيرة وصغيرة وأرقام ورموز
            'password'        => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            
            // رقم الجوال: مكون من 10 أرقام ويبدأ بـ 09 وغير مكرر
            'phone'           => ['required', 'regex:/^09\d{8}$/', 'unique:customers,phone'],
            
            // رقم الهوية الوطنية: 11 رقم بالضبط وفريد (غير مكرر لعميل آخر)
            'national_id'     => 'required|digits:11|unique:customers,national_id',
            
            'city'            => 'required|string|max:255',
            'neighborhood'    => 'required|string|max:255',
            'street'          => 'required|string|max:255',
            'building_number' => 'nullable|string|max:50',
            'location_link'   => 'nullable|string|max:500',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_token'] = \Illuminate\Support\Str::random(40);

        $customer = Customer::create($validated);

        \Illuminate\Support\Facades\Mail::to($customer->email)
            ->send(new \App\Mail\VerifyEmailMail($customer));

        return response()->json([
            'message' => 'تم إنشاء الحساب بنجاح. الرجاء التحقق من بريدك الإلكتروني لتفعيل الحساب قبل تسجيل الدخول.',
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('username', $validated['login'])
            ->orWhere('phone', $validated['login'])
            ->first();

        if (!$customer || !Hash::check($validated['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'login' => ['بيانات الدخول غير صحيحة.'],
            ]);
        }

        if (!$customer->email_verified_at) {
            return response()->json([
                'message' => 'يجب تفعيل بريدك الإلكتروني أولاً. الرجاء التحقق من صندوق بريدك.',
            ], 403);
        }

        $token = $customer->createToken('customer-token')->plainTextToken;

        return response()->json([
            'message'  => 'تم تسجيل الدخول بنجاح',
            'customer' => $customer,
            'token'    => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح',
        ]);
    }

    // بيانات العميل المسجل دخوله حالياً (مفيدة لملء الفورم تلقائياً عند "الحجز لي")
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $customer = $request->user();

        $validated = $request->validate([
            'full_name'        => 'sometimes|string|max:255',
            'email'            => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phone'            => 'sometimes|string|max:20|unique:customers,phone,' . $customer->id,
            'national_id'      => 'sometimes|string|max:20',
            'city'             => 'sometimes|string|max:255',
            'neighborhood'     => 'sometimes|string|max:255',
            'street'           => 'sometimes|string|max:255',
            'building_number'  => 'nullable|string|max:50',
            'location_link'    => 'nullable|string|max:500',
        ]);

        $customer->update($validated);

        return response()->json([
            'message'  => 'تم تحديث البيانات بنجاح',
            'customer' => $customer,
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5 ميغابايت (بالكيلوبايت)
        ]);

        $customer = $request->user();

        // حذف الصورة القديمة إن وجدت (توفير مساحة تخزين)
        if ($customer->avatar) {
            $oldPath = str_replace('/storage/', '', $customer->avatar);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $customer->update(['avatar' => '/storage/' . $path]);

        return response()->json([
            'message' => 'تم تحديث الصورة الشخصية بنجاح',
            'avatar'  => $customer->avatar,
        ]);
    }

    public function verifyEmail($token)
    {
        $customer = Customer::where('verification_token', $token)->first();

        if (!$customer) {
            return response('<h1 style="text-align:center; font-family:Tahoma; color:#c0392b; margin-top:100px;">رابط التفعيل غير صحيح أو منتهي الصلاحية.</h1>', 404);
        }

        $customer->update([
            'email_verified_at'  => now(),
            'verification_token' => null,
        ]);

        return response('
            <div style="text-align:center; font-family:Tahoma; margin-top:100px;">
                <h1 style="color:#1e7e34;">✅ تم تفعيل حسابك بنجاح</h1>
                <p style="color:#555; font-size:18px;">يمكنك الآن إغلاق هذه الصفحة والعودة لتسجيل الدخول.</p>
            </div>
        ');
    }
}