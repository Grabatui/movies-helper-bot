<?php

namespace App\Telegram\Dto\Poll;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;

/**
 * @description This object represents an answer of a user in a non-anonymous poll
 *
 * @see https://core.telegram.org/bots/api#pollanswer
 */
class PollAnswer implements DtoInterface
{
    /**
     * @description Unique poll identifier
     */
    public string $pollId;

    /**
     * @description The user, who changed the answer to the poll
     */
    public User $user;

    /**
     * @var int[]
     *
     * @description 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their
     * vote
     */
    public array $optionIds = [];

    public function __construct(string $pollId, User $user, array $optionIds)
    {
        $this->pollId = $pollId;
        $this->user = $user;
        $this->optionIds = $optionIds;
    }

    public static function makeFromArray(array $data): DtoInterface
    {
        return new static(
            $data['poll_id'],
            User::makeFromArray($data['user']),
            $data['option_ids']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'poll_id' => $this->pollId,
            'user' => $this->user->toArray(),
            'option_ids' => $this->optionIds,
        ];
    }
}
