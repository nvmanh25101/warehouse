<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRoleEnum extends Enum
{
    public const ADMIN = 0;
    public const IMPORTER = 1;
    public const EXPORTER = 2;

    public static function getKeyByValue($value): bool|int|string
    {
        return array_search($value, self::getArrayView(), true);
    }

    public static function getArrayView(): array
    {
        return [
            'Nhân viên nhập hàng' => self::IMPORTER,
            'Nhân viên xuất hàng' => self::EXPORTER,
        ];
    }
}
