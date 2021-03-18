<?php

namespace App\Telegram\Dto;

/**
 * @description This object describes the position on faces where a mask should be placed by default
 *
 * @see https://core.telegram.org/bots/api#maskposition
 */
class MaskPosition implements DtoInterface
{
    /**
     * @description The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”,
     * “mouth”, or “chin”
     */
    public string $point;

    /**
     * @description Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For
     * example, choosing -1.0 will place mask just to the left of the default mask position
     */
    public float $xShift;

    /**
     * @description Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For
     * example, 1.0 will place the mask just below the default mask position
     */
    public float $yShift;

    /**
     * @description Mask scaling coefficient. For example, 2.0 means double size
     */
    public float $scale;

    public function __construct(string $point, float $xShift, float $yShift, float $scale)
    {
        $this->point = $point;
        $this->xShift = $xShift;
        $this->yShift = $yShift;
        $this->scale = $scale;
    }

    public static function makeFromArray(array $data): self
    {
        return new static(
            $data['point'],
            $data['x_shift'],
            $data['y_shift'],
            $data['scale']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'point' => $this->point,
            'x_shift' => $this->xShift,
            'y_shift' => $this->yShift,
            'scale' => $this->scale,
        ];
    }
}
