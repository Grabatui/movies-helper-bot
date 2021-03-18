<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;

/**
 * @description This object contains information about an incoming shipping query
 */
class ShippingQuery implements DtoInterface
{
    /**
     * @description Unique query identifier
     */
    public string $id;

    /**
     * @description User who sent the query
     */
    public User $from;

    /**
     * @description Bot specified invoice payload
     */
    public string $invoicePayload;

    /**
     * @description User specified shipping address
     */
    public ShippingAddress $shippingAddress;

    public function __construct(string $id, User $from, string $invoicePayload, ShippingAddress $shippingAddress)
    {
        $this->id = $id;
        $this->from = $from;
        $this->invoicePayload = $invoicePayload;
        $this->shippingAddress = $shippingAddress;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['id'],
            User::makeFromArray($data['from']),
            $data['invoice_payload'],
            ShippingAddress::makeFromArray($data['shipping_address'])
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'from' => $this->from->toArray(),
            'invoice_payload' => $this->invoicePayload,
            'shipping_address' => $this->shippingAddress->toArray(),
        ];
    }
}
