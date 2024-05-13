<?php declare(strict_types=1);

namespace App\Enums\User;

use BenSampo\Enum\Enum;

final class RoleEnum extends Enum
{
    const ADMIN = 'ADMIN';
    const EMPLOYEE = 'EMPLOYEE';
    const USER = 'USER';
}
