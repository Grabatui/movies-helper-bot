<?php

namespace App\Telegram\Dto\Payment;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object contains basic information about an invoice
 *
 * @see https://core.telegram.org/bots/api#invoice
 */
class Invoice implements DtoInterface
{
    /**
     * @description Product name
     */
    public string $title;

    /**
     * @description Product description
     */
    public string $description;

    /**
     * @description Unique bot deep-linking parameter that can be used to generate this invoice
     */
    public string $startParameter;

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

    public function __construct(
        string $title,
        string $description,
        string $startParameter,
        string $currency,
        int $totalAmount
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->startParameter = $startParameter;
        $this->currency = $currency;
        $this->totalAmount = $totalAmount;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['title'],
            $data['description'],
            $data['start_parameter'],
            $data['currency'],
            $data['total_amount']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'start_parameter' => $this->startParameter,
            'currency' => $this->currency,
            'total_amount' => $this->totalAmount,
        ];
    }
}
