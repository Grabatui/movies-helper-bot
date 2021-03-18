<?php

namespace App\Telegram\Dto\Chat;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Location;

/**
 * @description Represents a location to which a chat is connected
 *
 * @see https://core.telegram.org/bots/api#chatlocation
 */
class ChatLocation implements DtoInterface
{
    /**
     * @description The location to which the supergroup is connected. Can't be a live location
     */
    public Location $location;

    /**
     * @description Location address; 1-64 characters, as defined by the chat owner
     */
    public string $address;

    public function __construct(Location $location, string $address)
    {
        $this->location = $location;
        $this->address = $address;
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            Location::makeFromArray($data['location']),
            $data['address']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'location' => $this->location->toArray(),
            'address' => $this->address,
        ];
    }
}
