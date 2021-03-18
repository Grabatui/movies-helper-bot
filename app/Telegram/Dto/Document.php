<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a general file (as opposed to photos, voice messages and audio files)
 *
 * @see https://core.telegram.org/bots/api#document
 */
class Document extends File
{
    /**
     * @description Document thumbnail as defined by sender
     */
    public ?PhotoSize $thumb = null;

    /**
     * @description Original filename as defined by sender
     */
    public ?string $fileName = null;

    /**
     * @description MIME type of the file as defined by sender
     */
    public ?string $mimeType = null;

    public static function makeFromArray(array $data): DtoInterface
    {
        $entity = new static(
            $data['file_id'],
            $data['file_unique_id']
        );

        $entity->thumb = ! empty($data['thumb']) ? PhotoSize::makeFromArray($data['thumb']) : null;
        $entity->fileName = $data['file_name'] ?? null;
        $entity->mimeType = $data['mime_type'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            parent::toArray(),
            clean_nullable_fields([
                'thumb' => $this->thumb ? $this->thumb->toArray() : null,
                'file_name' => $this->fileName,
                'mime_type' => $this->mimeType,
            ])
        );
    }
}
