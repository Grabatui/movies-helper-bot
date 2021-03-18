<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents an incoming inline query. When the user sends an empty query, your bot could
 * return some default or trending results
 */
class InlineQuery implements DtoInterface
{
    /**
     * @description Unique identifier for this query
     */
    public string $id;

    /**
     * @description Sender
     */
    public User $user;

    /**
     * @description Text of the query (up to 256 characters)
     */
    public string $query;

    /**
     * @description Offset of the results to be returned, can be controlled by the bot
     */
    public string $offset;

    /**
     * @description Sender location, only for bots that request user location
     */
    public ?Location $location = null;

    public function __construct(string $id, User $user, string $query, string $offset)
    {
        $this->id = $id;
        $this->user = $user;
        $this->query = $query;
        $this->offset = $offset;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['id'],
            User::makeFromArray($data['user']),
            $data['query'],
            $data['offset']
        );

        $entity->location = ! empty($data['location']) ? Location::makeFromArray($data['location']) : null;

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
                'user' => $this->user->toArray(),
                'query' => $this->query,
                'offset' => $this->offset,
            ],
            clean_nullable_fields([
                'location' => $this->location ? $this->location->toArray() : null,
            ])
        );
    }
}
