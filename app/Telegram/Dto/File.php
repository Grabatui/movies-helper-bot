<?php

namespace App\Telegram\Dto;

abstract class File implements DtoInterface
{
    /**
     * @description Identifier for this file, which can be used to download or reuse the file
     */
    public string $fileId;

    /**
     * @description Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file
     */
    public string $fileUniqueId;

    /**
     * @description File size
     */
    public ?int $fileSize = null;

    public function __construct(string $fileId, string $fileUniqueId)
    {
        $this->fileId = $fileId;
        $this->fileUniqueId = $fileUniqueId;
    }

    public function toArray()
    {
        return array_merge(
            [
                'file_id' => $this->fileId,
                'file_unique_id' => $this->fileUniqueId,
            ],
            clean_nullable_fields([
                'file_size' => $this->fileSize,
            ])
        );
    }
}
