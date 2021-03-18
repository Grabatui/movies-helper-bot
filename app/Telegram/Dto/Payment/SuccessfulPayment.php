<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object contains basic information about a successful payment
 *
 * @see https://core.telegram.org/bots/api#successfulpayment
 */
class SuccessfulPayment implements DtoInterface
{
    /**
     * @description Three-letter ISO 4217 currency code
     */
    public string $currency;

    /**
     * @description Total price in the smallest units of the currency (integer, not float/double). For example, for a
     * price of US$ 1.45 pass amount = 145. See the exp parameter in currencies.json, it shows the number of digits past
     * the decimal point for each currency (2 for the majority of currencies)
     *
     * @see https://core.telegram.org/bots/payments/currencies.json
     */
    public int $totalAmount;

    /**
     * @description Bot specified invoice payload
     */
    public string $invoicePayload;

    /**
     * @description Telegram payment identifier
     */
    public string $telegramPaymentChargeId;

    /**
     * @description Provider payment identifier
     */
    public string $providerPaymentChargeId;

    /**
     * @description Identifier of the shipping option chosen by the user
     */
    public ?string $shippingOptionId = null;

    /**
     * @description Order info provided by the user
     */
    public ?OrderInfo $orderInfo = null;

    public function __construct(
        string $currency,
        int $totalAmount,
        string $invoicePayload,
        string $telegramPaymentChargeId,
        string $providerPaymentChargeId
    )
    {
        $this->currency = $currency;
        $this->totalAmount = $totalAmount;
        $this->invoicePayload = $invoicePayload;
        $this->telegramPaymentChargeId = $telegramPaymentChargeId;
        $this->providerPaymentChargeId = $providerPaymentChargeId;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['currency'],
            $data['total_amount'],
            $data['invoice_payload'],
            $data['telegram_payment_charge_id'],
            $data['provider_payment_charge_id']
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
                'currency' => $this->currency,
                'total_amount' => $this->totalAmount,
                'invoice_payload' => $this->invoicePayload,
                'telegram_payment_charge_id' => $this->telegramPaymentChargeId,
                'provider_payment_charge_id' => $this->providerPaymentChargeId,
            ],
            clean_nullable_fields([
                'shipping_option_id' => $this->shippingOptionId,
                'order_info' => $this->orderInfo ? $this->orderInfo->toArray() : null,
            ])
        );
    }
}
