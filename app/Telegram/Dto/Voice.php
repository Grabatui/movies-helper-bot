<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a voice note
 *
 * @see https://core.telegram.org/bots/api#voice
 */
class Voice extends File
{
    /**
     * @description Duration of the audio in seconds as defined by sender
     */
    public int $duration;

    /**
     * @description MIME type of the file as defined by sender
     */
    public ?string $mimeType = null;

    public function __construct(string $fileId, string $fileUniqueId, int $duration)
    {
        parent::__construct($fileId, $fileUniqueId);

        $this->duration = $duration;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['duration']
        );

        $entity->fileSize = $data['file_size'] ?? null;
        $entity->mimeType = $data['mime_type'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'duration' => $this->duration,
            ],
            clean_nullable_fields([
                'mime_type' => $this->mimeType,
            ])
        );
    }
}
