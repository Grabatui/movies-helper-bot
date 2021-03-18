<?php

namespace App\Telegram\Dto\Enum;

class EncryptedPassportElementTypeEnum
{
    public const PERSONAL_DETAILS = 'personal_details';
    public const PASSPORT = 'passport';
    public const DRIVER_LICENSE = 'driver_license';
    public const IDENTITY_CARD = 'identity_card';
    public const INTERNAL_PASSPORT = 'internal_passport';
    public const ADDRESS = 'address';
    public const UTILITY_BILL = 'utility_bill';
    public const BANK_STATEMENT = 'bank_statement';
    public const RENTAL_AGREEMENT = 'rental_agreement';
    public const PASSPORT_REGISTRATION = 'passport_registration';
    public const TEMPORARY_REGISTRATION = 'temporary_registration';
    public const PHONE_NUMBER = 'phone_number';
    public const EMAIL = 'email';

    public const ALL = [
        self::PERSONAL_DETAILS,
        self::PASSPORT,
        self::DRIVER_LICENSE,
        self::IDENTITY_CARD,
        self::INTERNAL_PASSPORT,
        self::ADDRESS,
        self::UTILITY_BILL,
        self::BANK_STATEMENT,
        self::RENTAL_AGREEMENT,
        self::PASSPORT_REGISTRATION,
        self::TEMPORARY_REGISTRATION,
        self::PHONE_NUMBER,
        self::EMAIL,
    ];
}
