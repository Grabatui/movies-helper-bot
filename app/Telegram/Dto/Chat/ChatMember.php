<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\ChatMemberStatus;
use App\Telegram\Dto\User;
use Carbon\Carbon;

/**
 * @description This object contains information about one member of a chat
 *
 * @see https://core.telegram.org/bots/api#chatmember
 */
class ChatMember implements DtoInterface
{
    /**
     * @description Information about the user
     */
    public User $user;

    /**
     * @description The member's status in the chat. Can be “creator”, “administrator”, “member”, “restricted”, “left”
     * or “kicked”
     */
    public ChatMemberStatus $status;

    /**
     * @description Owner and administrators only. Custom title for this user
     */
    public ?string $customTitle = null;

    /**
     * @description Owner and administrators only. True, if the user's presence in the chat is hidden
     */
    public ?bool $isAnonymous = null;

    /**
     * @description Administrators only. True, if the bot is allowed to edit administrator privileges of that user
     */
    public ?bool $canBeEdited = null;

    /**
     * @description Administrators only. True, if the administrator can access the chat event log, chat statistics,
     * message statistics in channels, see channel members, see anonymous administrators in supergroups and ignore slow
     * mode. Implied by any other administrator privilege
     */
    public ?bool $canManageChat = null;

    /**
     * @description Administrators only. True, if the administrator can post in the channel; channels only
     */
    public ?bool $canPostMessages = null;

    /**
     * @description Administrators only. True, if the administrator can edit messages of other users and can pin
     * messages; channels only
     */
    public ?bool $canEditMessages = null;

    /**
     * @description Administrators only. True, if the administrator can delete messages of other users
     */
    public ?bool $canDeleteMessages = null;

    /**
     * @description Administrators only. True, if the administrator can manage voice chats
     */
    public ?bool $canManageVoiceChats = null;

    /**
     * @description Administrators only. True, if the administrator can restrict, ban or unban chat members
     */
    public ?bool $canRestrictMembers = null;

    /**
     * @description Administrators only. True, if the administrator can add new administrators with a subset of their
     * own privileges or demote administrators that he has promoted, directly or indirectly (promoted by administrators
     * that were appointed by the user)
     */
    public ?bool $canPromoteMembers = null;

    /**
     * @description Administrators and restricted only. True, if the user is allowed to change the chat title, photo and
     * other settings
     */
    public ?bool $canChangeInfo = null;

    /**
     * @description Administrators and restricted only. True, if the user is allowed to invite new users to the chat
     */
    public ?bool $canInviteUsers = null;

    /**
     * @description Administrators and restricted only. True, if the user is allowed to pin messages; groups and
     * supergroups only
     */
    public ?bool $canPinMessages = null;

    /**
     * @description Restricted only. True, if the user is a member of the chat at the moment of the request
     */
    public ?bool $isMember = null;

    /**
     * @description Restricted only. True, if the user is allowed to send text messages, contacts, locations and venues
     */
    public ?bool $canSendMessages = null;

    /**
     * @description Restricted only. True, if the user is allowed to send audios, documents, photos, videos, video notes
     * and voice notes
     */
    public ?bool $canSendMediaMessages = null;

    /**
     * @description Restricted only. True, if the user is allowed to send polls
     */
    public ?bool $canSendPolls = null;

    /**
     * @description Restricted only. True, if the user is allowed to send animations, games, stickers and use inline
     * bots
     */
    public ?bool $canSendOtherMessages = null;

    /**
     * @description Restricted only. True, if the user is allowed to add web page previews to their messages
     */
    public ?bool $canAddWebPagePreviews = null;

    /**
     * @description Restricted and kicked only. Date when restrictions will be lifted for this user; unix time
     */
    public ?Carbon $untilDate = null;

    public function __construct(User $user, ChatMemberStatus $status)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            User::makeFromArray($data['user']),
            new ChatMemberStatus($data['status'])
        );

        $entity->customTitle = $data['custom_title'] ?? null;
        $entity->isAnonymous = $data['is_anonymous'] ?? null;
        $entity->canBeEdited = $data['can_be_edited'] ?? null;
        $entity->canManageChat = $data['can_manage_chat'] ?? null;
        $entity->canPostMessages = $data['can_post_messages'] ?? null;
        $entity->canEditMessages = $data['can_edit_messages'] ?? null;
        $entity->canDeleteMessages = $data['can_delete_messages'] ?? null;
        $entity->canManageVoiceChats = $data['can_manage_voice_chats'] ?? null;
        $entity->canRestrictMembers = $data['can_restrict_members'] ?? null;
        $entity->canPromoteMembers = $data['can_promote_members'] ?? null;
        $entity->canChangeInfo = $data['can_change_info'] ?? null;
        $entity->canInviteUsers = $data['can_invite_users'] ?? null;
        $entity->canPinMessages = $data['can_pin_messages'] ?? null;
        $entity->isMember = $data['is_member'] ?? null;
        $entity->canSendMessages = $data['can_send_messages'] ?? null;
        $entity->canSendMediaMessages = $data['can_send_media_messages'] ?? null;
        $entity->canSendPolls = $data['can_send_polls'] ?? null;
        $entity->canSendOtherMessages = $data['can_send_other_messages'] ?? null;
        $entity->canAddWebPagePreviews = $data['can_add_web_page_previews'] ?? null;
        $entity->untilDate = ! empty($data['until_date']) ? Carbon::createFromTimestamp($data['until_date']) : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'user' => $this->user->toArray(),
                'status' => $this->status->getValue(),
            ],
            clean_nullable_fields([
                'custom_title' => $this->customTitle,
                'is_anonymous' => $this->isAnonymous,
                'can_be_edited' => $this->canBeEdited,
                'can_manage_chat' => $this->canManageChat,
                'can_post_messages' => $this->canPostMessages,
                'can_edit_messages' => $this->canEditMessages,
                'can_delete_messages' => $this->canDeleteMessages,
                'can_manage_voice_chats' => $this->canManageVoiceChats,
                'can_restrict_members' => $this->canRestrictMembers,
                'can_promote_members' => $this->canPromoteMembers,
                'can_change_info' => $this->canChangeInfo,
                'can_invite_users' => $this->canInviteUsers,
                'can_pin_messages' => $this->canPinMessages,
                'is_member' => $this->isMember,
                'can_send_messages' => $this->canSendMessages,
                'can_send_media_messages' => $this->canSendMediaMessages,
                'can_send_polls' => $this->canSendPolls,
                'can_send_other_messages' => $this->canSendOtherMessages,
                'can_add_web_page_previews' => $this->canAddWebPagePreviews,
                'until_date' => $this->untilDate ? $this->untilDate->getTimestamp() : null,
            ])
        );
    }
}
