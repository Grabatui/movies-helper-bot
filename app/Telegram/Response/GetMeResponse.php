<?php

namespace App\Telegram\Response;

use App\Telegram\Exception\WrongResponseException;

class GetMeResponse implements ResponseInterface
{
    public int $id;

    public bool $isBot;

    public string $firstName;

    public string $lastName = '';

    public string $username = '';

    public string $language = '';

    public bool $canJoinGroups = false;

    public bool $canReadAllGroupMessages = false;

    public bool $supportsInlineQueries = false;

    public function __construct(array $rawResponse)
    {
        $result = $rawResponse['result'] ?? null;

        if ( ! $result || ! isset($result['id']) || ! $result['id']) {
            throw new WrongResponseException(json_encode($rawResponse));
        }

        $this->id = $result['id'];
        $this->isBot = $result['is_bot'];
        $this->firstName = $result['first_name'];
        $this->lastName = $result['last_name'] ?? '';
        $this->username = $result['username'] ?? '';
        $this->language = $result['language'] ?? '';
        $this->canJoinGroups = $result['can_join_groups'] ?? false;
        $this->canReadAllGroupMessages = $result['can_read_all_group_messages'] ?? false;
        $this->supportsInlineQueries = $result['supports_inline_queries'] ?? false;
    }
}
