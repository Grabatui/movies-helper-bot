<?php

namespace App\Telegram\Dto\Passport;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\EncryptedPassportElementType;

/**
 * @description Contains information about documents or other Telegram Passport elements shared with the bot by the user
 *
 * @see https://core.telegram.org/bots/api#encryptedpassportelement
 */
class EncryptedPassportElement implements DtoInterface
{
    /**
     * @description Element type. One of “personal_details”, “passport”, “driver_license”, “identity_card”,
     * “internal_passport”, “address”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration”,
     * “temporary_registration”, “phone_number”, “email”
     */
    public EncryptedPassportElementType $type;

    /**
     * @description Base64-encoded element hash for using in PassportElementErrorUnspecified
     */
    public string $hash;

    /**
     * @description Base64-encoded encrypted Telegram Passport element data provided by the user, available for
     * “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types. Can
     * be decrypted and verified using the accompanying EncryptedCredentials
     */
    public ?string $data = null;

    /**
     * @description User's verified phone number, available only for “phone_number” type
     */
    public ?string $phoneNumber = null;

    /**
     * @description User's verified email address, available only for “email” type
     */
    public ?string $email = null;

    /**
     * @var PassportFile[]
     *
     * @description Array of encrypted files with documents provided by the user, available for “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be
     * decrypted and verified using the accompanying EncryptedCredentials
     */
    public array $files = [];

    /**
     * @description Encrypted file with the front side of the document, provided by the user. Available for “passport”,
     * “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified using the
     * accompanying EncryptedCredentials
     */
    public ?PassportFile $frontSide = null;

    /**
     * @description Encrypted file with the reverse side of the document, provided by the user. Available for
     * “driver_license” and “identity_card”. The file can be decrypted and verified using the accompanying
     * EncryptedCredentials
     */
    public ?PassportFile $reverseSide = null;

    /**
     * @description Encrypted file with the selfie of the user holding a document, provided by the user; available for
     * “passport”, “driver_license”, “identity_card” and “internal_passport”. The file can be decrypted and verified
     * using the accompanying EncryptedCredentials
     */
    public ?PassportFile $selfie = null;

    /**
     * @var PassportFile[]
     *
     * @description Array of encrypted files with translated versions of documents provided by the user. Available if
     * requested for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”,
     * “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types. Files can be
     * decrypted and verified using the accompanying EncryptedCredentials
     */
    public array $translation = [];

    public function __construct(EncryptedPassportElementType $type, string $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            new EncryptedPassportElementType($data['type']),
            $data['data']
        );

        $entity->phoneNumber = $data['phone_number'] ?? null;
        $entity->email = $data['email'] ?? null;
        $entity->files = ! empty($data['files'])
            ? arrays_to_array_of_objects($data['files'], PassportFile::class)
            : null;
        $entity->frontSide = ! empty($data['front_side'])
            ? PassportFile::makeFromArray($data['front_side'])
            : null;
        $entity->reverseSide = ! empty($data['reverse_side'])
            ? PassportFile::makeFromArray($data['reverse_side'])
            : null;
        $entity->selfie = ! empty($data['selfie'])
            ? PassportFile::makeFromArray($data['selfie'])
            : null;
        $entity->translation = ! empty($data['translation'])
            ? arrays_to_array_of_objects($data['translation'], PassportFile::class)
            : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'type' => $this->type->getValue(),
                'data' => $this->data,
            ],
            clean_nullable_fields([
                'phone_number' => $this->phoneNumber,
                'email' => $this->email,
                'files' => $this->files ? array_of_objects_to_arrays($this->files) : null,
                'front_side' => $this->frontSide ? $this->frontSide->toArray() : null,
                'reverse_side' => $this->reverseSide ? $this->reverseSide->toArray() : null,
                'selfie' => $this->selfie ? $this->selfie->toArray() : null,
                'translation' => $this->translation ? array_of_objects_to_arrays($this->translation) : null,
            ])
        );
    }
}
