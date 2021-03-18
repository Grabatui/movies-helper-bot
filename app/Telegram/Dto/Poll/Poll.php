<?php

namespace App\Telegram\Dto\Poll;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\PollType;
use App\Telegram\Dto\Message\MessageEntity;
use Carbon\Carbon;

/**
 * @description This object contains information about a poll
 *
 * @see https://core.telegram.org/bots/api#poll
 */
class Poll implements DtoInterface
{
    /**
     * @description Unique poll identifier
     */
    public string $id;

    /**
     * @description Poll question, 1-300 characters
     */
    public string $question;

    /**
     * @var PollOption[]
     *
     * @description List of poll options
     */
    public array $options;

    /**
     * @description Total number of users that voted in the poll
     */
    public int $totalVoterCount;

    /**
     * @description True, if the poll is closed
     */
    public bool $isClosed;

    /**
     * @description True, if the poll is anonymous
     */
    public bool $isAnonymous;

    /**
     * @description Poll type, currently can be “regular” or “quiz”
     */
    public PollType $type;

    /**
     * @description True, if the poll allows multiple answers
     */
    public bool $allowsMultipleAnswers;

    /**
     * @description 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which
     * are closed, or was sent (not forwarded) by the bot or to the private chat with the bot
     */
    public ?int $correctOptionId = null;

    /**
     * @description Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style
     * poll, 0-200 characters
     */
    public ?string $explanation = null;

    /**
     * @var MessageEntity[]
     *
     * @description Special entities like usernames, URLs, bot commands, etc. that appear in the explanation
     */
    public array $explanationEntities = [];

    /**
     * @description Amount of time in seconds the poll will be active after creation
     */
    public ?int $openPeriod = null;

    /**
     * @description Point in time (Unix timestamp) when the poll will be automatically closed
     */
    public ?Carbon $closeDate = null;

    public function __construct(
        string $id,
        string $question,
        array $options,
        int $totalVoterCount,
        bool $isClosed,
        bool $isAnonymous,
        PollType $type,
        bool $allowsMultipleAnswers
    )
    {
        $this->id = $id;
        $this->question = $question;
        $this->options = $options;
        $this->totalVoterCount = $totalVoterCount;
        $this->isClosed = $isClosed;
        $this->isAnonymous = $isAnonymous;
        $this->type = $type;
        $this->allowsMultipleAnswers = $allowsMultipleAnswers;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['id'],
            $data['question'],
            arrays_to_array_of_objects($data['options'], PollOption::class),
            $data['total_voter_count'],
            $data['is_closed'],
            $data['is_anonymous'],
            new PollType($data['type']),
            $data['allows_multiple_answers']
        );

        $entity->correctOptionId = $data['correct_option_id'] ?? null;
        $entity->explanation = $data['explanation'] ?? null;
        $entity->explanationEntities = ! empty($data['explanation_entities'])
            ? arrays_to_array_of_objects($data['explanation_entities'], MessageEntity::class)
            : null;
        $entity->openPeriod = $data['open_period'] ?? null;
        $entity->closeDate = ! empty($data['close_date']) ? Carbon::createFromTimestamp($data['close_date']) : null;

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
                'question' => $this->question,
                'options' => array_of_objects_to_arrays($this->options),
                'total_voter_count' => $this->totalVoterCount,
                'is_closed' => $this->isClosed,
                'is_anonymous' => $this->isAnonymous,
                'type' => $this->type->getValue(),
                'allows_multiple_answers' => $this->allowsMultipleAnswers,
            ],
            clean_nullable_fields([
                'correct_option_id' => $this->correctOptionId,
                'explanation' => $this->explanation,
                'explanation_entities' => array_of_objects_to_arrays($this->explanationEntities),
                'open_period' => $this->openPeriod,
                'close_date' => $this->closeDate ? $this->closeDate->getTimestamp() : null,
            ])
        );
    }
}
