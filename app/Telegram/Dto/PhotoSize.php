<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents one size of a photo or a file / sticker thumbnail
 *
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends File
{
    /**
     * @description Photo width
     */
    public int $width;

    /**
     * @description Photo height
     */
    public int $height;

    public function __construct(string $fileId, string $fileUniqueId, int $width, int $height)
    {
        parent::__construct($fileId, $fileUniqueId);

        $this->width = $width;
        $this->height = $height;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['width'],
            $data['height']
        );

        $entity->fileSize = $data['file_size'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'width' => $this->width,
                'height' => $this->height,
            ]
        );
    }
}
