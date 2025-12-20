<?php

namespace App\Helpers;

class PermissionHelper
{
    public static function canManageUsers()
    {
        return in_array(auth()->user()->role, ['super_admin', 'admin']);
    }

    public static function canCreateChecklist()
    {
        return in_array(auth()->user()->role, ['super_admin', 'admin', 'inspector']);
    }

    public static function canViewAllChecklists()
    {
        return in_array(auth()->user()->role, ['super_admin', 'admin', 'viewer']);
    }

    public static function canDeleteChecklist()
    {
        return in_array(auth()->user()->role, ['super_admin', 'admin']);
    }

    public static function canEditChecklist()
    {
        return in_array(auth()->user()->role, ['super_admin', 'admin', 'inspector']);
    }

    public static function isSuperAdmin()
    {
        return auth()->user()->role === 'super_admin';
    }

    public static function isAdmin()
    {
        return auth()->user()->role === 'admin';
    }

    public static function isInspector()
    {
        return auth()->user()->role === 'inspector';
    }

    public static function isViewer()
    {
        return auth()->user()->role === 'viewer';
    }
    
    public static function getRoleBadgeClass($role)
    {
        return match($role) {
            'super_admin' => 'bg-red-100 text-red-700',
            'admin' => 'bg-blue-100 text-blue-700',
            'inspector' => 'bg-green-100 text-green-700',
            'viewer' => 'bg-gray-100 text-gray-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
    
    public static function getRoleLabel($role)
    {
        return match($role) {
            'super_admin' => 'Super Admin',
            'admin' => 'Admin',
            'inspector' => 'Inspector',
            'viewer' => 'Viewer',
            default => ucfirst($role),
        };
    }
}