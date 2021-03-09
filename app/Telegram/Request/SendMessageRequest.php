<?php

namespace App\Telegram\Request;

use App\Telegram\Response\ResponseInterface;
use App\Telegram\Response\SendMessageResponse;

class SendMessageRequest extends AbstractPostRequest
{
    public int $chatId;

    public string $text;

    // TODO

    public function __construct(int $chatId, string $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
    }

    public function getUri(): string
    {
        return '/sendMessage';
    }

    public function getRequestData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'text' => $this->text,
        ];
    }

    public function makeResponse(array $rawResponse): ResponseInterface
    {
        return new SendMessageResponse($rawResponse);
    }
}
