<?php

namespace App\Telegram\Dto;

/**
 * @description This object represents a venue
 *
 * @see https://core.telegram.org/bots/api#venue
 */
class Venue implements DtoInterface
{
    /**
     * @description Venue location. Can't be a live location
     */
    public Location $location;

    /**
     * @description Name of the venue
     */
    public string $title;

    /**
     * @description Address of the venue
     */
    public string $address;

    /**
     * @description Foursquare identifier of the venue
     */
    public ?string $foursquareId = null;

    /**
     * @description Foursquare type of the venue. (For example, “arts_entertainment/default”,
     * “arts_entertainment/aquarium” or “food/icecream”.)
     */
    public ?string $foursquareType = null;

    /**
     * @description Google Places identifier of the venue
     */
    public ?string $googlePlaceId = null;

    /**
     * @description Google Places type of the venue
     *
     * @see https://developers.google.com/maps/documentation/places/web-service/supported_types
     */
    public ?string $googlePlaceType = null;

    public function __construct(Location $location, string $title, string $address)
    {
        $this->location = $location;
        $this->title = $title;
        $this->address = $address;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            Location::makeFromArray($data['location']),
            $data['title'],
            $data['address']
        );

        $entity->foursquareId = $data['foursquare_id'] ?? null;
        $entity->foursquareType = $data['foursquare_type'] ?? null;
        $entity->googlePlaceId = $data['google_place_id'] ?? null;
        $entity->googlePlaceType = $data['google_place_type'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'location' => $this->location->toArray(),
                'title' => $this->title,
                'address' => $this->address,
            ],
            clean_nullable_fields([
                'foursquare_id' => $this->foursquareId,
                'foursquare_type' => $this->foursquareType,
                'google_place_id' => $this->googlePlaceId,
                'google_place_type' => $this->googlePlaceType,
            ])
        );
    }
}
