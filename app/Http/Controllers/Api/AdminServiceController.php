<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminServiceController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:500',
            'price'       => 'nullable|numeric',
        ]);

        $service = Service::create($validated);

        return response()->json([
            'message' => 'تم إضافة الخدمة بنجاح',
            'service' => $service,
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'الخدمة غير موجودة'], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:500',
            'price'       => 'nullable|numeric',
        ]);

        $service->update($validated);

        return response()->json([
            'message' => 'تم تعديل الخدمة بنجاح',
            'service' => $service,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['message' => 'الخدمة غير موجودة'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'تم حذف الخدمة بنجاح']);
    }
}