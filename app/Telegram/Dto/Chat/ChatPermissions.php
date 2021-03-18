<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;

/**
 * @description Describes actions that a non-administrator user is allowed to take in a chat
 *
 * @see https://core.telegram.org/bots/api#chatpermissions
 */
class ChatPermissions implements DtoInterface
{
    /**
     * @description True, if the user is allowed to send text messages, contacts, locations and venues
     */
    public ?bool $canSendMessages = null;

    /**
     * @description True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes,
     * implies can_send_messages
     */
    public ?bool $canSendMediaMessages = null;

    /**
     * @description True, if the user is allowed to send polls, implies can_send_messages
     */
    public ?bool $canSendPolls = null;

    /**
     * @description True, if the user is allowed to send animations, games, stickers and use inline bots, implies
     * can_send_media_messages
     */
    public ?bool $canSendOtherMessages = null;

    /**
     * @description True, if the user is allowed to add web page previews to their messages, implies
     * can_send_media_messages
     */
    public ?bool $canAddWebPagePreviews = null;

    /**
     * @description True, if the user is allowed to change the chat title, photo and other settings. Ignored in public
     * supergroups
     */
    public ?bool $canChangeInfo = null;

    /**
     * @description True, if the user is allowed to invite new users to the chat
     */
    public ?bool $canInviteUsers = null;

    /**
     * @description True, if the user is allowed to pin messages. Ignored in public supergroups
     */
    public ?bool $canPinMessages = null;

    public static function makeFromArray(array $data): self
    {
        $entity = new static();

        $entity->canSendMessages = $data['can_send_messages'] ?? null;
        $entity->canSendMediaMessages = $data['can_send_media_messages'] ?? null;
        $entity->canSendPolls = $data['can_send_polls'] ?? null;
        $entity->canSendOtherMessages = $data['can_send_other_messages'] ?? null;
        $entity->canAddWebPagePreviews = $data['can_add_web_page_previews'] ?? null;
        $entity->canChangeInfo = $data['can_change_info'] ?? null;
        $entity->canInviteUsers = $data['can_invite_users'] ?? null;
        $entity->canPinMessages = $data['can_pin_messages'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return clean_nullable_fields([
            'can_send_messages' => $this->canSendMessages,
            'can_send_media_messages' => $this->canSendMediaMessages,
            'can_send_polls' => $this->canSendPolls,
            'can_send_other_messages' => $this->canSendOtherMessages,
            'can_add_web_page_previews' => $this->canAddWebPagePreviews,
            'can_change_info' => $this->canChangeInfo,
            'can_invite_users' => $this->canInviteUsers,
            'can_pin_messages' => $this->canPinMessages,
        ]);
    }
}
