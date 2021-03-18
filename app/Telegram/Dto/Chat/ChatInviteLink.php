<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;
use Carbon\Carbon;

/**
 * @description Represents an invite link for a chat
 *
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink implements DtoInterface
{
    /**
     * @description The invite link. If the link was created by another chat administrator, then the second part of the
     * link will be replaced with “…”
     */
    public string $inviteLink;

    /**
     * @description Creator of the link
     */
    public User $creator;

    /**
     * @description True, if the link is primary
     */
    public bool $isPrimary;

    /**
     * @description True, if the link is revoked
     */
    public bool $isRevoked;

    /**
     * @description Point in time (Unix timestamp) when the link will expire or has been expired
     */
    public ?Carbon $expireDate = null;

    /**
     * @description Maximum number of users that can be members of the chat simultaneously after joining the chat via
     * this invite link; 1-99999
     */
    public ?int $memberLimit = null;

    public function __construct(string $inviteLink, User $creator, bool $isPrimary, bool $isRevoked)
    {
        $this->inviteLink = $inviteLink;
        $this->creator = $creator;
        $this->isPrimary = $isPrimary;
        $this->isRevoked = $isRevoked;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['invite_link'],
            User::makeFromArray($data['creator']),
            $data['is_primary'],
            $data['is_revoked']
        );

        $entity->expireDate = ! empty($data['expire_date']) ? Carbon::createFromTimestamp($data['expire_date']) : null;
        $entity->memberLimit = $data['member_limit'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'invite_link' => $this->inviteLink,
                'creator' => $this->creator->toArray(),
                'is_primary' => $this->isPrimary,
                'is_revoked' => $this->isRevoked,
            ],
            clean_nullable_fields([
                'expire_date' => $this->expireDate ? $this->expireDate->getTimestamp() : null,
                'member_limit' => $this->memberLimit,
            ])
        );
    }
}
