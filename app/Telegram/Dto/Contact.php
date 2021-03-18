<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a phone contact
 *
 * @see https://core.telegram.org/bots/api#contact
 */
class Contact implements DtoInterface
{
    /**
     * @description Contact's phone number
     */
    public string $phoneNumber;

    /**
     * @description Contact's first name
     */
    public string $firstName;

    /**
     * @description Contact's last name
     */
    public ?string $lastName = null;

    /**
     * @description Contact's user identifier in Telegram. This number may have more than 32 significant bits and some
     * programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant
     * bits, so a 64-bit integer or double-precision float type are safe for storing this identifier
     */
    public ?int $userId = null;

    /**
     * @description Additional data about the contact in the form of a vCard
     */
    public ?string $vCard = null;

    public function __construct(string $phoneNumber, string $firstName)
    {
        $this->phoneNumber = $phoneNumber;
        $this->firstName = $firstName;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['phone_number'],
            $data['first_name']
        );

        $entity->lastName = $data['last_name'] ?? null;
        $entity->userId = $data['user_id'] ?? null;
        $entity->vCard = $data['vcard'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'phone_number' => $this->phoneNumber,
                'first_name' => $this->firstName,
            ],
            clean_nullable_fields([
                'last_name' => $this->lastName,
                'user_id' => $this->userId,
                'vcard' => $this->vCard,
            ])
        );
    }
}
