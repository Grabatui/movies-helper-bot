<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a video message (available in Telegram apps as of v.4.0)
 *
 * @see https://core.telegram.org/bots/api#videonote
 */
class VideoNote extends File
{
    /**
     * @description Video width and height (diameter of the video message) as defined by sender
     */
    public int $length;

    /**
     * @description Duration of the video in seconds as defined by sender
     */
    public int $duration;

    /**
     * @description Video thumbnail
     */
    public ?PhotoSize $thumb = null;

    public function __construct(string $fileId, string $fileUniqueId, int $length, int $duration)
    {
        parent::__construct($fileId, $fileUniqueId);

        $this->length = $length;
        $this->duration = $duration;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['length'],
            $data['duration']
        );

        $entity->fileSize = $data['file_size'] ?? null;
        $entity->thumb = ! empty($data['thumb']) ? PhotoSize::makeFromArray($data['thumb']) : null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'length' => $this->length,
                'duration' => $this->duration,
            ],
            clean_nullable_fields([
                'thumb' => $this->thumb ? $this->thumb->toArray() : null,
            ])
        );
    }
}
