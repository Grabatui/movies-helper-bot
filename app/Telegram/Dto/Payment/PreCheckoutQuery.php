<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;

/**
 * @description This object contains information about an incoming pre-checkout query
 *
 * @see https://core.telegram.org/bots/api#precheckoutquery
 */
class PreCheckoutQuery implements DtoInterface
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
     * @description Three-letter ISO 4217 currency code
     */
    public string $currency;

    /**
     * @description Total price in the smallest units of the currency (integer, not float/double). For example, for a
     * price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past
     * the decimal point for each currency (2 for the majority of currencies)
     */
    public int $totalAmount;

    /**
     * @description Bot specified invoice payload
     */
    public string $invoicePayload;

    /**
     * @description Identifier of the shipping option chosen by the user
     */
    public ?string $shippingOptionId = null;

    /**
     * @description Order info provided by the user
     */
    public ?OrderInfo $orderInfo = null;

    public function __construct(string $id, User $from, string $currency, int $totalAmount, string $invoicePayload)
    {
        $this->id = $id;
        $this->from = $from;
        $this->currency = $currency;
        $this->totalAmount = $totalAmount;
        $this->invoicePayload = $invoicePayload;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['id'],
            User::makeFromArray($data['from']),
            $data['currency'],
            $data['total_amount'],
            $data['invoice_payload']
        );

        $entity->shippingOptionId = $data['shipping_option_id'] ?? null;
        $entity->orderInfo = ! empty($data['order_info']) ? OrderInfo::makeFromArray($data['order_info']) : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'id' => $this->id,
                'from' => $this->from->toArray(),
                'currency' => $this->currency,
                'total_amount' => $this->totalAmount,
                'invoice_payload' => $this->invoicePayload,
            ],
            clean_nullable_fields([
                'shipping_option_id' => $this->shippingOptionId,
                'order_info' => $this->orderInfo ? $this->orderInfo->toArray() : null,
            ])
        );
    }
}
