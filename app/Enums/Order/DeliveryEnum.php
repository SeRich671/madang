<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

final class DeliveryEnum extends Enum
{
    const PICK_UP = 'pick_up';
    const COURIER = 'courier';

    public static function getPrice($value): string
    {
        if($value == self::COURIER) {
            return '21.00';
        }

        return '0.00';
    }
}
