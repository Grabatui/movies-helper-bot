<?php

namespace App\Telegram\Dto\Passport;

use App\Telegram\Dto\DtoInterface;

/**
 * @description Contains information about Telegram Passport data shared with the bot by the user
 *
 * @see https://core.telegram.org/bots/api#passportdata
 */
class PassportData implements DtoInterface
{
    /**
     * @var EncryptedPassportElement[]
     *
     * @description Array with information about documents and other Telegram Passport elements that was shared with the
     * bot
     */
    public array $data = [];

    /**
     * @description Encrypted credentials required to decrypt the data
     */
    public EncryptedCredentials $credentials;

    public function __construct(array $data, EncryptedCredentials $credentials)
    {
        $this->data = $data;
        $this->credentials = $credentials;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            arrays_to_array_of_objects($data['data'], EncryptedPassportElement::class),
            EncryptedCredentials::makeFromArray($data['credentials'])
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'data' => array_of_objects_to_arrays($this->data),
            'credentials' => $this->credentials->toArray(),
        ];
    }
}
