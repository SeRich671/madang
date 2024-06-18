<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusEnum extends Enum implements LocalizedEnum
{
    const NEW = 'NEW';
    const IN_PROGRESS = 'IN_PROGRESS';
    const DONE = 'DONE';
    const ABORTED = 'ABORTED';
}
