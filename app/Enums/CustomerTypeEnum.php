<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CustomerTypeEnum extends Enum
{
    const KHACH_HANG = 0;
    const NHA_CUNG_CAP = 1;
}
