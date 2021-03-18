<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a video file
 *
 * @see https://core.telegram.org/bots/api#video
 */
class Video extends Image
{
    /**
     * @description Duration of the video in seconds as defined by sender
     */
    public int $duration;

    /**
     * @description Original filename as defined by sender
     */
    public ?string $fileName = null;

    /**
     * @description Mime type of a file as defined by sender
     */
    public ?string $mimeType = null;

    public function __construct(string $fileId, string $fileUniqueId, int $width, int $height, int $duration)
    {
        parent::__construct($fileId, $fileUniqueId, $width, $height);

        $this->duration = $duration;
    }

    public static function makeFromArray(array $data): DtoInterface
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['width'],
            $data['height'],
            $data['duration']
        );

        $entity->fileName = $data['file_name'] ?? null;
        $entity->mimeType = $data['mime_type'] ?? null;
        $entity->fileSize = $data['file_size'] ?? null;

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
                'file_name' => $this->fileName,
                'mime_type' => $this->mimeType,
                'file_size' => $this->fileSize,
            ])
        );
    }
}
