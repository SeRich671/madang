<?php declare(strict_types=1);

namespace App\Enums\Order;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class PaymentEnum extends Enum implements LocalizedEnum
{
    const PREPEYMENT = 'prepeyment';
    const POSTPAYMENT = 'postpayment';

    public static function getPrice($value, $delivery): string
    {
        if($value == self::POSTPAYMENT && $delivery == DeliveryEnum::COURIER) {
            return '8.00';
        }

        return '0.00';
    }
}
