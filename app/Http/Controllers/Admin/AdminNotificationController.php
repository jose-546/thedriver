<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    /**
     * Obtenir le nombre de notifications non lues (AJAX)
     */
    public function getUnreadCount()
    {
        $count = AdminNotification::getUnreadCount();
        
        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Obtenir les notifications récentes (AJAX)
     */
    public function getRecent()
    {
        $notifications = AdminNotification::getRecentUnread(10);
        
        return response()->json([
            'notifications' => $notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'created_at' => $notification->created_at->locale('fr')->diffForHumans(),
                    'data' => $notification->data
                ];
            })
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(AdminNotification $notification)
    {
        $notification->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification marquée comme lue'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        AdminNotification::markAllAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Toutes les notifications ont été marquées comme lues'
        ]);
    }

    /**
     * Gérer le clic sur une notification
     */
    public function handleClick(AdminNotification $notification)
    {
        // Marquer comme lue
        $notification->markAsRead();
        
        // Rediriger selon le type de notification
        switch ($notification->type) {
            case 'expired_reservation':
                return redirect()->route('admin.reservations.expired')
                    ->with('success', 'Notification consultée');
                
            default:
                return redirect()->route('admin.dashboard')
                    ->with('info', 'Notification consultée');
        }
    }
}