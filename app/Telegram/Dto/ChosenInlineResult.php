<?php

namespace App\Telegram\Dto;

/**
 * @description Represents a result of an inline query that was chosen by the user and sent to their chat partner
 */
class ChosenInlineResult implements DtoInterface
{
    /**
     * @description The unique identifier for the result that was chosen
     */
    public string $resultId;

    /**
     * @description The user that chose the result
     */
    public User $user;

    /**
     * @description The query that was used to obtain the result
     */
    public string $query;

    /**
     * @description Sender location, only for bots that require user location
     */
    public ?Location $location = null;

    /**
     * @description Identifier of the sent inline message. Available only if there is an inline keyboard attached to the
     * message. Will be also received in callback queries and can be used to edit the message
     */
    public ?string $inlineMessageId = null;

    public function __construct(string $resultId, User $user, string $query)
    {
        $this->resultId = $resultId;
        $this->user = $user;
        $this->query = $query;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['result_id'],
            User::makeFromArray($data['user']),
            $data['query']
        );

        $entity->location = ! empty($data['location']) ? Location::makeFromArray($data['location']) : null;
        $entity->inlineMessageId = $data['inline_message_id'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'result_id' => $this->resultId,
                'user' => $this->user->toArray(),
                'query' => $this->query,
            ],
            clean_nullable_fields([
                'location' => $this->location ? $this->location->toArray() : null,
                'inline_message_id' => $this->inlineMessageId,
            ])
        );
    }
}
