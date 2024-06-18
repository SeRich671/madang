<?php declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class RoleEnum extends Enum implements LocalizedEnum
{
    const ADMIN = 'ADMIN';
    const EMPLOYEE = 'EMPLOYEE';
    const USER = 'USER';
}
