<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\ChatType;
use App\Telegram\Dto\Message\Message;

/**
 * @description This object represents a chat
 *
 * @see https://core.telegram.org/bots/api#chat
 */
class Chat implements DtoInterface
{
    /**
     * @description Unique identifier for this chat. This number may have more than 32 significant bits and some
     * programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant
     * bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier
     */
    public int $id;

    /**
     * @description Type of chat, can be either “private”, “group”, “supergroup” or “channel”
     */
    public ChatType $type;

    /**
     * @description Title, for supergroups, channels and group chats
     */
    public ?string $title = null;

    /**
     * @description Username, for private chats, supergroups and channels if available
     */
    public ?string $username = null;

    /**
     * @description First name of the other party in a private chat
     */
    public ?string $firstName = null;

    /**
     * @description Last name of the other party in a private chat
     */
    public ?string $lastName = null;

    /**
     * @description Chat photo. Returned only in getChat
     */
    public ?ChatPhoto $photo = null;

    /**
     * @description Bio of the other party in a private chat. Returned only in getChat
     */
    public ?string $biography = null;

    /**
     * @description Description, for groups, supergroups and channel chats. Returned only in getChat
     */
    public ?string $description = null;

    /**
     * @description Primary invite link, for groups, supergroups and channel chats. Returned only in getChat
     */
    public ?string $inviteLink = null;

    /**
     * @description The most recent pinned message (by sending date). Returned only in getChat
     */
    public ?Message $pinnedMessage = null;

    /**
     * @description Default chat member permissions, for groups and supergroups. Returned only in getChat
     */
    public ?ChatPermissions $permissions = null;

    /**
     * @description For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged
     * user. Returned only in getChat
     */
    public ?int $slowModeDelay = null;

    /**
     * @description The time after which all messages sent to the chat will be automatically deleted; in seconds.
     * Returned only in getChat
     */
    public ?int $messageAutoDeleteTime = null;

    /**
     * @description For supergroups, name of group sticker set. Returned only in getChat
     */
    public ?string $stickerSetName = null;

    /**
     * @description True, if the bot can change the group sticker set. Returned only in getChat
     */
    public ?bool $canSetStickerName = null;

    /**
     * @description Unique identifier for the linked chat, i.e. the discussion group identifier for a channel and vice
     * versa; for supergroups and channel chats. This identifier may be greater than 32 bits and some programming
     * languages may have difficulty/silent defects in interpreting it. But it is smaller than 52 bits, so a signed 64
     * bit integer or double-precision float type are safe for storing this identifier. Returned only in getChat
     */
    public ?int $linkedChatId = null;

    /**
     * @description For supergroups, the location to which the supergroup is connected. Returned only in getChat
     */
    public ?ChatLocation $location = null;

    public function __construct(int $id, ChatType $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['id'],
            new ChatType($data['type'])
        );

        $entity->title = $data['title'] ?? null;
        $entity->username = $data['username'] ?? null;
        $entity->firstName = $data['first_name'] ?? null;
        $entity->lastName = $data['last_name'] ?? null;
        $entity->photo = ! empty($data['photo'])
            ? ChatPhoto::makeFromArray($data['photo'])
            : null;
        $entity->biography = $data['bio'] ?? null;
        $entity->inviteLink = $data['invite_link'] ?? null;
        $entity->pinnedMessage = ! empty($data['pinned_message'])
            ? Message::makeFromArray($data['pinned_message'])
            : null;
        $entity->permissions = ! empty($data['permissions'])
            ? ChatPermissions::makeFromArray($data['permissions'])
            : null;
        $entity->slowModeDelay = $data['slow_mode_delay'] ?? null;
        $entity->messageAutoDeleteTime = $data['message_auto_delete_time'] ?? null;
        $entity->stickerSetName = $data['sticker_set_name'] ?? null;
        $entity->canSetStickerName = $data['can_set_sticker_name'] ?? null;
        $entity->linkedChatId = $data['linked_chat_id'] ?? null;
        $entity->location = ! empty($data['location'])
            ? ChatLocation::makeFromArray($data['location'])
            : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'id' => $this->id,
                'type' => $this->type->getValue(),
            ],
            clean_nullable_fields([
                'title' => $this->title,
                'username' => $this->username,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'photo' => $this->photo ? $this->photo->toArray() : null,
                'bio' => $this->biography,
                'invite_link' => $this->inviteLink,
                'pinned_message' => $this->pinnedMessage ? $this->pinnedMessage->toArray() : null,
                'permissions' => $this->permissions ? $this->permissions->toArray() : null,
                'slow_mode_delay' => $this->slowModeDelay,
                'message_auto_delete_time' => $this->messageAutoDeleteTime,
                'sticker_set_name' => $this->stickerSetName,
                'can_set_sticker_name' => $this->canSetStickerName,
                'linked_chat_id' => $this->linkedChatId,
                'location' => $this->location ? $this->location->toArray() : null,
            ])
        );
    }
}
