<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a sticker
 *
 * @see https://core.telegram.org/bots/api#sticker
 */
class Sticker extends Image
{
    /**
     * @description True, if the sticker is animated
     */
    public bool $isAnimated;

    /**
     * @description Emoji associated with the sticker
     */
    public ?string $emoji = null;

    /**
     * @description Name of the sticker set to which the sticker belongs
     */
    public ?string $setName = null;

    /**
     * @description For mask stickers, the position where the mask should be placed
     */
    public ?MaskPosition $maskPosition = null;

    public function __construct(string $fileId, string $fileUniqueId, int $width, int $height, bool $isAnimated)
    {
        parent::__construct($fileId, $fileUniqueId, $width, $height);

        $this->isAnimated = $isAnimated;
    }

    public static function makeFromArray(array $data): DtoInterface
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id'],
            $data['width'],
            $data['height'],
            $data['is_animated']
        );

        $entity->emoji = $data['emoji'] ?? null;
        $entity->setName = $data['set_name'] ?? null;
        $entity->maskPosition = ! empty($data['mask_position'])
            ? MaskPosition::makeFromArray($data['mask_position'])
            : null;
        $entity->fileSize = $data['file_size'] ?? null;

        return $entity;
    }

    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            [
                'is_animated' => $this->isAnimated,
            ],
            clean_nullable_fields([
                'emoji' => $this->emoji,
                'set_name' => $this->setName,
                'mask_position' => $this->maskPosition ? $this->maskPosition->toArray() : null,
            ])
        );
    }
}
