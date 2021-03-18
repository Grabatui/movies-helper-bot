<?php

namespace App\Telegram\Dto\Keyboard;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @description This object represents one button of the reply keyboard. For simple text buttons String can be used
 * instead of this object to specify text of the button
 */
class KeyboardButton implements Arrayable
{
    /**
     * @description Text of the button. If none of the optional fields are used, it will be sent as a message when the
     * button is pressed
     */
    public string $text;

    /**
     * @description If True, the user's phone number will be sent as a contact when the button is pressed. Available in
     * private chats only
     */
    public ?bool $requestContact = null;

    /**
     * @description If True, the user's current location will be sent when the button is pressed. Available in private
     * chats only
     */
    public ?bool $requestLocation = null;

    /**
     * @description If specified, the user will be asked to create a poll and send it to the bot when the button is
     * pressed. Available in private chats only
     */
    public ?KeyboardButtonPollType $requestPoll = null;

    public function toArray(): array
    {
        return array_merge(
            [
                'text' => $this->text,
            ],
            clean_nullable_fields([
                'request_contact' => $this->requestContact,
                'request_location' => $this->requestContact,
                'request_poll' => $this->requestPoll ? $this->requestPoll->getRequestData() : null,
            ])
        );
    }
}
