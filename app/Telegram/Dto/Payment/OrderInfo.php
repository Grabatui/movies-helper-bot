<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents information about an order
 *
 * @see https://core.telegram.org/bots/api#orderinfo
 */
class OrderInfo implements DtoInterface
{
    /**
     * @description User name
     */
    public ?string $name = null;

    /**
     * @description User phone number
     */
    public ?string $phoneNumber = null;

    /**
     * @description User email
     */
    public ?string $email = null;

    /**
     * @description User shipping address
     */
    public ?ShippingAddress $shippingAddress = null;

    public static function makeFromArray(array $data): self
    {
        $entity = new static();

        $entity->name = $data['name'] ?? null;
        $entity->phoneNumber = $data['phone_number'] ?? null;
        $entity->email = $data['email'] ?? null;
        $entity->shippingAddress = ! empty($data['shipping_address'])
            ? ShippingAddress::makeFromArray($data['shipping_address'])
            : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return clean_nullable_fields([
            'name' => $this->name,
            'phone_number' => $this->phoneNumber,
            'email' => $this->email,
            'shipping_address' => $this->shippingAddress ? $this->shippingAddress->toArray() : null,
        ]);
    }
}
