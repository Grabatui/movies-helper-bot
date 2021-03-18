<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a Telegram user or bot
 */
class User implements DtoInterface
{
    /**
     * @description Unique identifier for this user or bot. This number may have more than 32 significant bits and some
     * programming languages may have difficulty/silent defects in interpreting it. But it has at most 52 significant
     * bits, so a 64-bit integer or double-precision float type are safe for storing this identifier
     */
    public int $id;

    /**
     * @description True, if this user is a bot
     */
    public bool $isBot;

    /**
     * @description User's or bot's first name
     */
    public string $firstName;

    /**
     * @description User's or bot's last name
     */
    public ?string $lastName = null;

    /**
     * @description User's or bot's username
     */
    public ?string $username = null;

    /**
     * @description IETF language tag of the user's language
     */
    public ?string $languageCode = null;

    /**
     * @description  True, if the bot can be invited to groups. Returned only in getMe
     */
    public ?bool $canJoinGroups = null;

    /**
     * @description True, if privacy mode is disabled for the bot. Returned only in getMe
     */
    public ?bool $canReadAllGroupMessages = null;

    /**
     * @description True, if the bot supports inline queries. Returned only in getMe
     */
    public ?bool $supportsInlineQueries = null;

    public function __construct(int $id, bool $isBot, string $firstName)
    {
        $this->id = $id;
        $this->isBot = $isBot;
        $this->firstName = $firstName;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static($data['id'], $data['is_bot'], $data['first_name']);

        $entity->lastName = $data['last_name'] ?? null;
        $entity->username = $data['username'] ?? null;
        $entity->languageCode = $data['language_code'] ?? null;
        $entity->canJoinGroups = $data['can_join_groups'] ?? null;
        $entity->canReadAllGroupMessages = $data['can_read_all_group_messages'] ?? null;
        $entity->supportsInlineQueries = $data['supports_inline_queries'] ?? null;

        return $entity;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'id' => $this->id,
                'is_bot' => $this->isBot,
                'first_name' => $this->firstName,
            ],
            clean_nullable_fields([
                'last_name' => $this->lastName,
                'username' => $this->username,
                'language_code' => $this->languageCode,
                'can_join_groups' => $this->canJoinGroups,
                'can_read_all_group_messages' => $this->canReadAllGroupMessages,
                'supports_inline_queries' => $this->supportsInlineQueries,
            ])
        );
    }
}
