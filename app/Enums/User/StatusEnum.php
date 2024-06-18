<?php declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class StatusEnum extends Enum implements LocalizedEnum
{
    const NOT_ACCEPTED = 'NOT_ACCEPTED';
    const ACCEPTED = 'ACCEPTED';
    const ARCHIVED = 'ARCHIVED';
    const DELETED = 'DELETED';
}
