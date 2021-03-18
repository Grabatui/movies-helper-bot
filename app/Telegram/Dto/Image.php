<?php

namespace App\Telegram\Dto;

abstract class Image extends File
{
    /**
     * @description Width
     */
    public int $width;

    /**
     * @description Height
     */
    public int $height;

    /**
     * @description Thumbnail as defined by sender
     */
    public ?PhotoSize $thumb = null;

    public function __construct(string $fileId, string $fileUniqueId, int $width, int $height)
    {
        parent::__construct($fileId, $fileUniqueId);

        $this->width = $width;
        $this->height = $height;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'width' => $this->width,
                'height' => $this->height,
            ],
            clean_nullable_fields([
                'thumb' => $this->thumb ? $this->thumb->toArray() : null,
            ])
        );
    }
}
