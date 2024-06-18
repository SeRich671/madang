<?php declare(strict_types=1);

namespace App\Enums\Department;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusEnum extends Enum implements LocalizedEnum
{
    const ON = 'ON';
    const OFF = 'OFF';
}
