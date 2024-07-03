<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class WarningEnum extends Enum
{
    public const CANH_BAO = 0;
    public const BINH_THUONG = 1;

    public static function getKeyByValue($value): bool|int|string
    {
        return array_search($value, self::getArrayView(), true);
    }

    public static function getArrayView(): array
    {
        return [
            'Cảnh báo' => self::CANH_BAO,
            'Bình thường' => self::BINH_THUONG,
        ];
    }
}
