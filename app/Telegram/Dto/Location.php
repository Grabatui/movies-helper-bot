<?php

namespace App\Telegram\Dto;

class Location
{
    public float $longitude;

    public float $latitude;

    public float $horizontalAccuracy = 0;

    public int $livePeriod = 0;

    public int $heading = 1;

    public int $proximityAlertRadius = 0;
}
