<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MailingStatus extends Enum
{
    const CREATED = 'created';
    const IN_PROGRESS = 'progress';
    const FINISHED = 'finished';
    const DELETED = 'deleted';
}
