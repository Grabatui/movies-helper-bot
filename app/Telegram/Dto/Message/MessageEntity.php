<?php

namespace App\Telegram\Dto\Message;

use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Field\MessageEntityType;
use App\Telegram\Dto\User;

/**
 * @description This object represents one special entity in a text message. For example, hashtags, usernames, URLs, etc.
 *
 * @see https://core.telegram.org/bots/api#messageentity
 */
class MessageEntity implements DtoInterface
{
    /**
     * @description Type of the entity. Can be “mention” (@username), “hashtag” (#hashtag), “cashtag” ($USD),
     * “bot_command” (/start@jobs_bot), “url” (https://telegram.org), “email” (do-not-reply@telegram.org),
     * “phone_number” (+1-212-555-0123), “bold” (bold text), “italic” (italic text), “underline” (underlined text),
     * “strikethrough” (strikethrough text), “code” (monowidth string), “pre” (monowidth block), “text_link” (for
     * clickable text URLs), “text_mention” (for users without usernames)
     */
    public MessageEntityType $type;

    /**
     * @description Offset in UTF-16 code units to the start of the entity
     */
    public int $offset;

    /**
     * @description Length of the entity in UTF-16 code units
     */
    public int $length;

    /**
     * @description For “text_link” only, url that will be opened after user taps on the text
     */
    public ?string $url = null;

    /**
     * @description For “text_mention” only, the mentioned user
     */
    public ?User $user = null;

    /**
     * @description For “pre” only, the programming language of the entity text
     */
    public ?string $language = null;

    public function __construct(MessageEntityType $type, int $offset, int $length)
    {
        $this->type = $type;
        $this->offset = $offset;
        $this->length = $length;
    }

    public static function makeFromArray(array $data): DtoInterface
    {
        $entity = new static(
            new MessageEntityType($data['type']),
            $data['offset'],
            $data['length']
        );

        $entity->url = $data['url'] ?? null;
        $entity->user = ! empty($data['user']) ? User::makeFromArray($data['user']) : null;
        $entity->language = $data['language'] ?? null;

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'type' => $this->type->getValue(),
                'offset' => $this->offset,
                'length' => $this->length,
            ],
            clean_nullable_fields([
                'url' => $this->url,
                'user' => $this->user ? $this->user->toArray() : null,
                'language' => $this->language,
            ])
        );
    }
}
