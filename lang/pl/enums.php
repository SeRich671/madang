<?php

return [
    \App\Enums\Department\StatusEnum::class => [
        \App\Enums\Department\StatusEnum::ON => 'Włączony',
        \App\Enums\Department\StatusEnum::OFF => 'Wyłączony',
    ],
    \App\Enums\Order\DeliveryEnum::class => [
        \App\Enums\Order\DeliveryEnum::PICK_UP => 'Odbiór własny',
        \App\Enums\Order\DeliveryEnum::COURIER => 'Dostawa kurierem',
    ],
    \App\Enums\Order\PaymentEnum::class => [
        \App\Enums\Order\PaymentEnum::PREPEYMENT => 'Przedpłata',
        \App\Enums\Order\PaymentEnum::POSTPAYMENT => 'Opłata przy odbiorze',
    ],
    \App\Enums\Order\StatusEnum::class => [
        \App\Enums\Order\StatusEnum::NEW => 'Nowe',
        \App\Enums\Order\StatusEnum::IN_PROGRESS => 'W realizacji',
        \App\Enums\Order\StatusEnum::DONE => 'Zakończone',
        \App\Enums\Order\StatusEnum::ABORTED => 'Odrzucone',
    ],
    \App\Enums\User\RoleEnum::class => [
        \App\Enums\User\RoleEnum::USER => 'Użytkownik',
        \App\Enums\User\RoleEnum::EMPLOYEE => 'Pracownik',
        \App\Enums\User\RoleEnum::ADMIN => 'Administrator',
    ],
    \App\Enums\User\StatusEnum::class => [
        \App\Enums\User\StatusEnum::NOT_ACCEPTED => 'Niezaakceptowany',
        \App\Enums\User\StatusEnum::ACCEPTED => 'Zaakceptowany',
        \App\Enums\User\StatusEnum::ARCHIVED => 'Zarchiwizowany',
        \App\Enums\User\StatusEnum::DELETED => 'Usunięty(Zarchiwizowany)',
    ],
];
