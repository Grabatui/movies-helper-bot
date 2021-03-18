<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a shipping address
 */
class ShippingAddress implements DtoInterface
{
    /**
     * @description ISO 3166-1 alpha-2 country code
     */
    public string $countryCode;

    /**
     * @description State, if applicable
     */
    public string $state;

    /**
     * @description City
     */
    public string $city;

    /**
     * @description First line for the address
     */
    public string $streetLineFirst;

    /**
     * @description Second line for the address
     */
    public string $streetLineSecond;

    /**
     * @description Address post code
     */
    public string $postCode;

    public function __construct(
        string $countryCode,
        string $state,
        string $city,
        string $streetLineFirst,
        string $streetLineSecond,
        string $postCode
    )
    {
        $this->countryCode = $countryCode;
        $this->state = $state;
        $this->city = $city;
        $this->streetLineFirst = $streetLineFirst;
        $this->streetLineSecond = $streetLineSecond;
        $this->postCode = $postCode;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['country_code'],
            $data['state'],
            $data['city'],
            $data['street_line1'],
            $data['street_line2'],
            $data['post_code']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'country_code' => $this->countryCode,
            'state' => $this->state,
            'city' => $this->city,
            'street_line1' => $this->streetLineFirst,
            'street_line2' => $this->streetLineSecond,
            'post_code' => $this->postCode,
        ];
    }
}
