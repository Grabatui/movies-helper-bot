<?php

namespace App\Telegram\Dto\Event;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\User;

/**
 * @description This object represents the content of a service message, sent whenever a user in the chat triggers a
 * proximity alert set by another user
 *
 * @see https://core.telegram.org/bots/api#proximityalerttriggered
 */
class ProximityAlertTriggered implements DtoInterface
{
    /**
     * @description User that triggered the alert
     */
    public User $traveller;

    /**
     * @description User that set the alert
     */
    public User $watcher;

    /**
     * @description The distance between the users
     */
    public int $distance;

    public function __construct(User $traveller, User $watcher, int $distance)
    {
        $this->traveller = $traveller;
        $this->watcher = $watcher;
        $this->distance = $distance;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            User::makeFromArray($data['traveller']),
            User::makeFromArray($data['watcher']),
            $data['distance']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'traveller' => $this->traveller->toArray(),
            'watcher' => $this->watcher->toArray(),
            'distance' => $this->distance,
        ];
    }
}
