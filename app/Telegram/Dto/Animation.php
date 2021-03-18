<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents an animation file (GIF or H.264/MPEG-4 AVC video without sound)
 *
 * @see https://core.telegram.org/bots/api#animation
 */
class Animation extends Image
{
    /**
     * @description Duration of the video in seconds as defined by sender
     */
    public int $duration;

    /**
     * @description Original animation filename as defined by sender
     */
    public ?string $fileName = null;

    /**
     * @description MIME type of the file as defined by sender
     */
    public ?string $mimeType = null;

    public function __construct(string $fileId, string $fileUniqueId, int $width, int $height, int $duration)
    {
        parent::__construct($fileId, $fileUniqueId, $width, $height);

        $this->duration = $duration;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['width'],
            $data['height'],
            $data['duration']
        );

        $entity->thumb = ! empty($data['thumb']) ? PhotoSize::makeFromArray($data['thumb']) : null;
        $entity->fileName = $data['file_name'] ?? null;
        $entity->mimeType = $data['mime_type'] ?? null;
        $entity->fileSize = $data['file_size'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
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
            ])
        );
    }
}
