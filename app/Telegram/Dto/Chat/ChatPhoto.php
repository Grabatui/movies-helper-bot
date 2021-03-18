<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a chat photo
 *
 * @see https://core.telegram.org/bots/api#chatphoto
 */
class ChatPhoto implements DtoInterface
{
    /**
     * @description File identifier of small (160x160) chat photo. This file_id can be used only for photo download and
     * only for as long as the photo is not changed
     */
    public string $smallFileId;

    /**
     * @description Unique file identifier of small (160x160) chat photo, which is supposed to be the same over time and
     * for different bots. Can't be used to download or reuse the file
     */
    public string $smallFileUniqueId;

    /**
     * @description File identifier of big (640x640) chat photo. This file_id can be used only for photo download and
     * only for as long as the photo is not changed
     */
    public string $bigFileId;

    /**
     * @description Unique file identifier of big (640x640) chat photo, which is supposed to be the same over time and
     * for different bots. Can't be used to download or reuse the file
     */
    public string $bigFileUniqueId;

    public function __construct(
        string $smallFileId,
        string $smallFileUniqueId,
        string $bigFileId,
        string $bigFileUniqueId
    )
    {
        $this->smallFileId = $smallFileId;
        $this->smallFileUniqueId = $smallFileUniqueId;
        $this->bigFileId = $bigFileId;
        $this->bigFileUniqueId = $bigFileUniqueId;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['small_file_id'],
            $data['small_file_unique_id'],
            $data['big_file_id'],
            $data['big_file_unique_id']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'small_file_id' => $this->smallFileId,
            'small_file_unique_id' => $this->smallFileUniqueId,
            'big_file_id' => $this->bigFileId,
            'big_file_unique_id' => $this->bigFileUniqueId,
        ];
    }
}
