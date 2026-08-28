<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    // عرض كل إشعارات العميل المسجل دخوله
    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'unread_count' => $notifications->where('is_read', false)->count(),
            'notifications' => $notifications,
        ]);
    }

    // تعليم إشعار واحد كمقروء
    public function markAsRead(Request $request, $id): JsonResponse
    {
        $notification = $request->user()->notifications()->find($id);

        if (!$notification) {
            return response()->json(['message' => 'الإشعار غير موجود'], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['message' => 'تم تعليم الإشعار كمقروء']);
    }

    // تعليم كل الإشعارات كمقروءة
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->notifications()->update(['is_read' => true]);

        return response()->json(['message' => 'تم تعليم كل الإشعارات كمقروءة']);
    }
}