<?php

namespace App\Telegram\Dto\Passport;

use App\Telegram\Dto\DtoInterface;

/**
 * @description Contains data required for decrypting and authenticating EncryptedPassportElement. See the Telegram
 * Passport Documentation for a complete description of the data decryption and authentication processes
 *
 * @see https://core.telegram.org/bots/api#encryptedcredentials
 */
class EncryptedCredentials implements DtoInterface
{
    /**
     * @description Base64-encoded encrypted JSON-serialized data with unique user's payload, data hashes and secrets
     * required for EncryptedPassportElement decryption and authentication
     */
    public string $data;

    /**
     * @description Base64-encoded data hash for data authentication
     */
    public string $hash;

    /**
     * @description Base64-encoded secret, encrypted with the bot's public RSA key, required for data decryption
     */
    public string $secret;

    public function __construct(string $data, string $hash, string $secret)
    {
        $this->data = $data;
        $this->hash = $hash;
        $this->secret = $secret;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['data'],
            $data['hash'],
            $data['secret']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'data' => $this->data,
            'hash' => $this->hash,
            'secret' => $this->secret,
        ];
    }
}
