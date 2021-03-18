<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Chat\ChatInviteLink;
use App\Telegram\Dto\Chat\ChatMember;
use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;
use Carbon\Carbon;

/**
 * @description This object represents changes in the status of a chat member
 *
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 */
class ChatMemberUpdated implements DtoInterface
{
    /**
     * @description Chat the user belongs to
     */
    public Chat $chat;

    /**
     * @description Performer of the action, which resulted in the change
     */
    public User $from;

    /**
     * @description Date the change was done in Unix time
     */
    public Carbon $date;

    /**
     * @description Previous information about the chat member
     */
    public ChatMember $oldChatMember;

    /**
     * @description New information about the chat member
     */
    public ChatMember $newChatMember;

    /**
     * @description Chat invite link, which was used by the user to join the chat; for joining by invite link events
     * only
     */
    public ?ChatInviteLink $inviteLink = null;

    public function __construct(
        Chat $chat,
        User $from,
        Carbon $date,
        ChatMember $oldChatMember,
        ChatMember $newChatMember
    )
    {
        $this->chat = $chat;
        $this->from = $from;
        $this->date = $date;
        $this->oldChatMember = $oldChatMember;
        $this->newChatMember = $newChatMember;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            Chat::makeFromArray($data['chat']),
            User::makeFromArray($data['from']),
            Carbon::createFromTimestamp($data['date']),
            ChatMember::makeFromArray($data['old_chat_member']),
            ChatMember::makeFromArray($data['new_chat_member'])
        );

        $entity->inviteLink = ! empty($data['invite_link'])
            ? ChatInviteLink::makeFromArray($data['invite_link'])
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
                'chat' => $this->chat->toArray(),
                'from' => $this->from->toArray(),
                'date' => $this->date->getTimestamp(),
                'old_chat_member' => $this->oldChatMember->toArray(),
                'new_chat_member' => $this->newChatMember->toArray(),
            ],
            clean_nullable_fields([
                'invite_link' => $this->inviteLink ? $this->inviteLink->toArray() : null,
            ])
        );
    }
}
