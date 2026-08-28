<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::all();

        return response()->json($services);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;

        // التحقق من رفع صورة وحفظها في مجلد storage/app/public/services
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('services', 'public');
            $imagePath = Storage::url($path);
        }

        $service = Service::create([
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return response()->json($service, 201);
    }

    public function destroy(int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        // مسح ملف الصورة من السيرفر إن وجد
        if ($service->image) {
            $relativePath = str_replace('/storage/', '', $service->image);
            Storage::disk('public')->delete($relativePath);
        }

        $service->delete();

        return response()->json(['message' => 'تم حذف الخدمة بنجاح']);
    }
}