<?php

namespace App\Enums;

enum UserRoleEnum: int
{
    case ADMIN = 0;

    public static function getRole(int $role): string
    {
        return match ($role) {
            self::ADMIN => 'Admin',
            default => 'User',
        };
    }
}
