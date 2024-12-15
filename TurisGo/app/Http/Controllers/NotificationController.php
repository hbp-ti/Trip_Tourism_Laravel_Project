<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function showNotifications(Request $request)
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications
        ]);
    }

    // Marca a notificação como lida
    public function updateNotification($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->is_read = true;
            $notification->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Not Found'], 404);
    }

    // Exclui uma notificação individual
    public function deleteNotification($id)
    {
        $notification = Notification::find($id);

        if ($notification && $notification->user_id == Auth::id()) {
            $notification->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Not Found'], 404);
    }

    // Exclui todas as notificações do usuário
    public function deleteAllNotifications()
    {
        $user = Auth::user();
        Notification::where('user_id', $user->id)->delete();

        return response()->json(['success' => true]);
    }
}
