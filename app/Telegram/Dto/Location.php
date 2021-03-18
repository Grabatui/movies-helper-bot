<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a point on the map
 *
 * @see https://core.telegram.org/bots/api#location
 */
class Location implements DtoInterface
{
    /**
     * @description Longitude as defined by sender
     */
    public float $longitude;

    /**
     * @description Latitude as defined by sender
     */
    public float $latitude;

    /**
     * @description The radius of uncertainty for the location, measured in meters; 0-1500
     */
    public ?float $horizontalAccuracy = null;

    /**
     * @description Time relative to the message sending date, during which the location can be updated, in seconds.
     * For active live locations only
     */
    public ?int $livePeriod = null;

    /**
     * @description The direction in which user is moving, in degrees; 1-360. For active live locations only
     */
    public ?int $heading = null;

    /**
     * @description Maximum distance for proximity alerts about approaching another chat member, in meters. For sent
     * live locations only
     */
    public ?int $proximityAlertRadius = null;

    public function __construct(float $longitude, float $latitude)
    {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static($data['longitude'], $data['latitude']);

        $entity->horizontalAccuracy = $data['horizontal_accuracy'] ?? null;
        $entity->livePeriod = $data['live_period'] ?? null;
        $entity->heading = $data['heading'] ?? null;
        $entity->proximityAlertRadius = $data['proximity_alert_radius'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
            ],
            clean_nullable_fields([
                'horizontal_accuracy' => $this->horizontalAccuracy,
                'live_period' => $this->livePeriod,
                'heading' => $this->heading,
                'proximity_alert_radius' => $this->proximityAlertRadius,
            ]),
        );
    }
}
