<?php

namespace App\Telegram\Dto;

use App\Telegram\Dto\Message\MessageEntity;

/**
 * @description This object represents a game. Use BotFather to create and edit games, their short names will act as
 * unique identifiers
 *
 * @see https://core.telegram.org/bots/api#game
 */
class Game implements DtoInterface
{
    /**
     * @description Title of the game
     */
    public string $title;

    /**
     * @description Description of the game
     */
    public string $description;

    /**
     * @var PhotoSize[]
     *
     * @description Photo that will be displayed in the game message in chats
     */
    public array $photo;

    /**
     * @description Brief description of the game or high scores included in the game message. Can be automatically
     * edited to include current high scores for the game when the bot calls setGameScore, or manually edited using
     * editMessageText. 0-4096 characters
     */
    public ?string $text = null;

    /**
     * @var MessageEntity[]
     *
     * @description Special entities that appear in text, such as usernames, URLs, bot commands, etc
     */
    public array $textEntities = [];

    /**
     * @description Animation that will be displayed in the game message in chats. Upload via BotFather
     */
    public ?Animation $animation = null;

    public function __construct(string $title, string $description, array $photo)
    {
        $this->title = $title;
        $this->description = $description;
        $this->photo = $photo;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['title'],
            $data['description'],
            arrays_to_array_of_objects($data['photo'], PhotoSize::class)
        );

        $entity->text = $data['text'] ?? null;
        $entity->textEntities = ! empty($data['text_entities'])
            ? arrays_to_array_of_objects($data['text_entities'], MessageEntity::class)
            : null;
        $entity->animation = ! empty($data['animation']) ? Animation::makeFromArray($data['animation']) : null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'title' => $this->title,
                'description' => $this->description,
                'photo' => array_of_objects_to_arrays($this->photo),
            ],
            clean_nullable_fields([
                'text' => $this->text,
                'text_entities' => $this->textEntities ? array_of_objects_to_arrays($this->textEntities) : null,
                'animation' => $this->animation ? $this->animation->toArray() : null,
            ])
        );
    }
}
