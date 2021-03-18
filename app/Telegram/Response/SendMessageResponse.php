<?php

namespace App\Telegram\Response;

use App\Telegram\Dto\Message\Message;
use App\Telegram\Exception\WrongResponseException;

/**
 * @see https://core.telegram.org/bots/api#sendmessage
 */
class SendMessageResponse implements ResponseInterface
{
    public Message $message;

    public function __construct(array $rawResponse)
    {
        $result = $rawResponse['result'] ?? null;

        if ( ! $result) {
            throw new WrongResponseException(
                json_encode($rawResponse)
            );
        }

        $this->message = Message::makeFromArray($result);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'result' => $this->message->toArray(),
        ];
    }
}
