<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents an audio file to be treated as music by the Telegram clients
 *
 * @see https://core.telegram.org/bots/api#audio
 */
class Audio extends File
{
    /**
     * @description Duration of the audio in seconds as defined by sender
     */
    public int $duration;

    /**
     * @description Performer of the audio as defined by sender or by audio tags
     */
    public ?string $performer = null;

    /**
     * @description Title of the audio as defined by sender or by audio tags
     */
    public ?string $title = null;

    /**
     * @description Original filename as defined by sender
     */
    public ?string $fileName = null;

    /**
     * @description MIME type of the file as defined by sender
     */
    public ?string $mimeType = null;

    /**
     * @description Thumbnail of the album cover to which the music file belongs
     */
    public ?PhotoSize $thumb = null;

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
        $entity->performer = $data['performer'] ?? null;
        $entity->title = $data['title'] ?? null;
        $entity->fileName = $data['file_name'] ?? null;
        $entity->mimeType = $data['mime_type'] ?? null;
        $entity->thumb = ! empty($data['thumb']) ? PhotoSize::makeFromArray($data['thumb']) : null;

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
                'performer' => $this->performer,
                'title' => $this->title,
                'file_name' => $this->fileName,
                'mime_type' => $this->mimeType,
                'thumb' => $this->thumb ? $this->thumb->toArray() : null,
            ])
        );
    }
}
