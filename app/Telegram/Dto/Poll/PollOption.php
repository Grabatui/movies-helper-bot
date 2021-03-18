<?php

namespace App\Telegram\Dto\Poll;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object contains information about one answer option in a poll
 *
 * @see https://core.telegram.org/bots/api#polloption
 */
class PollOption implements DtoInterface
{
    /**
     * @description This object contains information about one answer option in a poll
     */
    public string $text;

    /**
     * @description Number of users that voted for this option
     */
    public int $voterCount;

    public function __construct(string $text, int $voterCount)
    {
        $this->text = $text;
        $this->voterCount = $voterCount;
    }

    public static function makeFromArray(array $data): DtoInterface
    {
        return new static(
            $data['text'],
            $data['voter_count']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'text' => $this->text,
            'voter_count' => $this->voterCount,
        ];
    }
}
