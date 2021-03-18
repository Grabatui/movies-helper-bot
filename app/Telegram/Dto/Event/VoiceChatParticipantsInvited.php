<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;

/**
 * @description This object represents a service message about new members invited to a voice chat
 *
 * @see https://core.telegram.org/bots/api#voicechatparticipantsinvited
 */
class VoiceChatParticipantsInvited implements DtoInterface
{
    /**
     * @var User[]
     *
     * @description New members that were invited to the voice chat
     */
    public array $users = [];

    public static function makeFromArray(array $data): self
    {
        $entity = new static();

        $entity->users = ! empty($data['users'])
            ? arrays_to_array_of_objects($data['users'], User::class)
            : [];

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return clean_nullable_fields([
            'users' => $this->users ? array_of_objects_to_arrays($this->users) : null,
        ]);
    }
}
