<?php

namespace App\Telegram\Response;

use App\Telegram\Dto\User;
use App\Telegram\Exception\WrongResponseException;

/**
 * @see https://core.telegram.org/bots/api#getme
 */
class GetMeResponse implements ResponseInterface
{
    public User $user;

    public function __construct(array $rawResponse)
    {
        $result = $rawResponse['result'] ?? null;

        if ( ! $result) {
            throw new WrongResponseException(
                json_encode($rawResponse)
            );
        }

        $this->user = User::makeFromArray($result);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'result' => $this->user->toArray(),
        ];
    }
}
