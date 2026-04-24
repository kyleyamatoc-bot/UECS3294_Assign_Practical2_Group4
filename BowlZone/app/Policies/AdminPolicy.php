<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user can access admin dashboard
     */
    public function viewAdminDashboard(User $user)
    {
        return (bool) $user->is_admin;
    }

    /**
     * Check if user can view contact messages
     */
    public function viewContactMessages(User $user)
    {
        return (bool) $user->is_admin;
    }

    /**
     * Check if user can delete contact messages
     */
    public function deleteContactMessage(User $user)
    {
        return (bool) $user->is_admin;
    }

    /**
     * Check if user can mark contact message as read
     */
    public function markAsRead(User $user)
    {
        return (bool) $user->is_admin;
    }
}
