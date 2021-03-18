<?php

namespace App\Telegram\Dto\Passport;

use App\Telegram\Dto\File;
use Carbon\Carbon;

/**
 * @description This object represents a file uploaded to Telegram Passport. Currently all Telegram Passport files are
 * in JPEG format when decrypted and don't exceed 10MB
 *
 * @see https://core.telegram.org/bots/api#passportfile
 */
class PassportFile extends File
{
    /**
     * @description Unix time when the file was uploaded
     */
    public Carbon $fileDate;

    public function __construct(string $fileId, string $fileUniqueId, Carbon $fileDate)
    {
        parent::__construct($fileId, $fileUniqueId);

        $this->fileDate = $fileDate;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            Carbon::createFromTimestamp($data['file_date'])
        );

        $entity->fileSize = $data['file_size'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'file_date' => $this->fileDate->getTimestamp(),
            ]
        );
    }
}
