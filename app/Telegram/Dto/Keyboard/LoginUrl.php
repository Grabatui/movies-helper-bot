<?php

namespace App\Telegram\Dto\Keyboard;

use App\Telegram\Dto\DtoInterface;

/**
 * @description This object represents a parameter of the inline keyboard button used to automatically authorize a user.
 * Serves as a great replacement for the Telegram Login Widget when the user is coming from Telegram. All the user needs
 * to do is tap/click a button and confirm that they want to log in
 *
 * @see https://core.telegram.org/bots/api#loginurl
 */
class LoginUrl implements DtoInterface
{
    /**
     * @description An HTTP URL to be opened with user authorization data added to the query string when the button is
     * pressed. If the user refuses to provide authorization data, the original URL without information about the user
     * will be opened. The data added is the same as described in Receiving authorization data
     */
    public string $url;

    /**
     * @description New text of the button in forwarded messages
     */
    public ?string $forwardText = null;

    /**
     * @description Username of a bot, which will be used for user authorization. See Setting up a bot for more details.
     * If not specified, the current bot's username will be assumed. The url's domain must be the same as the domain
     * linked with the bot
     */
    public ?string $botUsername = null;

    /**
     * @description Pass True to request the permission for your bot to send messages to the user
     */
    public ?bool $requestWriteAccess = null;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static($data['url']);

        $entity->forwardText = $data['forward_text'] ?? null;
        $entity->botUsername = $data['bot_username'] ?? null;
        $entity->requestWriteAccess = $data['request_write_access'] ?? null;

        return $entity;
    }

    public function toArray(): array
    {
        return array_merge(
            [
                'url' => $this->url,
            ],
            clean_nullable_fields([
                'forward_text' => $this->forwardText,
                'bot_username' => $this->botUsername,
                'request_write_access' => $this->requestWriteAccess,
            ])
        );
    }
}
