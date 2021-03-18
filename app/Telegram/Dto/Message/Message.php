<?php

namespace App\Telegram\Dto\Message;

use App\Telegram\Dto\Animation;
use App\Telegram\Dto\Audio;
use App\Telegram\Dto\Chat\Chat;
use App\Telegram\Dto\Contact;
use App\Telegram\Dto\Dice;
use App\Telegram\Dto\Document;
use App\Telegram\Dto\DtoInterface;
use App\Telegram\Dto\Event\MessageAutoDeleteTimerChanged;
use App\Telegram\Dto\Event\ProximityAlertTriggered;
use App\Telegram\Dto\Event\VoiceChatEnded;
use App\Telegram\Dto\Event\VoiceChatParticipantsInvited;
use App\Telegram\Dto\Event\VoiceChatStarted;
use App\Telegram\Dto\Game;
use App\Telegram\Dto\Keyboard\InlineKeyboardMarkup;
use App\Telegram\Dto\Location;
use App\Telegram\Dto\Passport\PassportData;
use App\Telegram\Dto\Payment\Invoice;
use App\Telegram\Dto\Payment\SuccessfulPayment;
use App\Telegram\Dto\PhotoSize;
use App\Telegram\Dto\Poll\Poll;
use App\Telegram\Dto\Sticker;
use App\Telegram\Dto\User;
use App\Telegram\Dto\Venue;
use App\Telegram\Dto\Video;
use App\Telegram\Dto\VideoNote;
use App\Telegram\Dto\Voice;
use Carbon\Carbon;

/**
 * @description This object represents a message
 *
 * @see https://core.telegram.org/bots/api#message
 */
class Message implements DtoInterface
{
    /**
     * @description Unique message identifier inside this chat
     */
    public int $id;

    /**
     * @description Date the message was sent in Unix time
     */
    public Carbon $date;

    /**
     * @description Conversation the message belongs to
     */
    public Chat $chat;

    /**
     * @description Sender, empty for messages sent to channels
     */
    public ?User $from = null;

    /**
     * @description Sender of the message, sent on behalf of a chat. The channel itself for channel messages. The
     * supergroup itself for messages from anonymous group administrators. The linked channel for messages automatically
     * forwarded to the discussion group
     */
    public ?Chat $senderChat = null;

    /**
     * @description For forwarded messages, sender of the original message
     */
    public ?User $forwardFrom = null;

    /**
     * @description For messages forwarded from channels or from anonymous administrators, information about the
     * original sender chat
     */
    public ?Chat $forwardFromChat = null;

    /**
     * @description For messages forwarded from channels, identifier of the original message in the channel
     */
    public ?int $forwardFromMessageId = null;

    /**
     * @description For messages forwarded from channels, signature of the post author if present
     */
    public ?string $forwardSignature = null;

    /**
     * @description Sender's name for messages forwarded from users who disallow adding a link to their account in
     * forwarded messages
     */
    public ?string $forwardSenderName = null;

    /**
     * @description For forwarded messages, date the original message was sent in Unix time
     */
    public ?Carbon $forwardDate = null;

    /**
     * @description For replies, the original message. Note that the Message object in this field will not contain
     * further reply_to_message fields even if it itself is a reply
     */
    public ?Message $replyToMessage = null;

    /**
     * @description Bot through which the message was sent
     */
    public ?User $viaBot = null;

    /**
     * @description Date the message was last edited in Unix time
     */
    public ?Carbon $editDate = null;

    /**
     * @description The unique identifier of a media message group this message belongs to
     */
    public ?string $mediaGroupId = null;

    /**
     * @description Signature of the post author for messages in channels, or the custom title of an anonymous group
     * administrator
     */
    public ?string $authorSignature = null;

    /**
     * @description For text messages, the actual UTF-8 text of the message, 0-4096 characters
     */
    public ?string $text = null;

    /**
     * @var MessageEntity[]
     *
     * @description For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     */
    public array $entities = [];

    /**
     * @description Message is an animation, information about the animation. For backward compatibility, when this
     * field is set, the document field will also be set
     */
    public ?Animation $animation = null;

    /**
     * @description Message is an audio file, information about the file
     */
    public ?Audio $audio = null;

    /**
     * @description Message is a general file, information about the file
     */
    public ?Document $document = null;

    /**
     * @var PhotoSize[]
     *
     * @description Message is a photo, available sizes of the photo
     */
    public array $photo = [];

    /**
     * @description Message is a sticker, information about the sticker
     */
    public ?Sticker $sticker = null;

    /**
     * @description Message is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * @description Message is a video note, information about the video message
     */
    public ?VideoNote $videoNote = null;

    /**
     * @description Message is a voice message, information about the file
     */
    public ?Voice $voice = null;

    /**
     * @description Caption for the animation, audio, document, photo, video or voice, 0-1024 characters
     */
    public ?string $caption = null;

    /**
     * @var MessageEntity[]
     *
     * @description For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear
     * in the caption
     */
    public array $captionEntities = [];

    /**
     * @description Message is a shared contact, information about the contact
     */
    public ?Contact $contact = null;

    /**
     * @description Message is a dice with random value
     */
    public ?Dice $dice = null;

    /**
     * @description Message is a game, information about the game
     */
    public ?Game $game = null;

    /**
     * @description Message is a native poll, information about the poll
     */
    public ?Poll $poll = null;

    /**
     * @description Message is a venue, information about the venue. For backward compatibility, when this field is set,
     * the location field will also be set
     */
    public ?Venue $venue = null;

    /**
     * @description Message is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * @var User[]
     *
     * @description New members that were added to the group or supergroup and information about them (the bot itself
     * may be one of these members)
     */
    public array $newChatMembers = [];

    /**
     * @description A member was removed from the group, information about them (this member may be the bot itself)
     */
    public ?User $leftChatMember = null;

    /**
     * @description A chat title was changed to this value
     */
    public ?string $newChatTitle = null;

    /**
     * @var PhotoSize[]
     *
     * @description A chat photo was change to this value
     */
    public array $newChatPhoto = [];

    /**
     * @description Service message: the chat photo was deleted
     */
    public ?bool $deleteChatPhoto = null;

    /**
     * @description Service message: the group has been created
     */
    public ?bool $groupChatCreated = null;

    /**
     * @description Service message: the supergroup has been created. This field can't be received in a message coming
     * through updates, because bot can't be a member of a supergroup when it is created. It can only be found in
     * reply_to_message if someone replies to a very first message in a directly created supergroup
     */
    public ?bool $superGroupChatCreated = null;

    /**
     * @description Service message: the channel has been created. This field can't be received in a message coming
     * through updates, because bot can't be a member of a channel when it is created. It can only be found in
     * reply_to_message if someone replies to a very first message in a channel
     */
    public ?bool $channelChatCreated = null;

    /**
     * @description Service message: auto-delete timer settings changed in the chat
     */
    public ?MessageAutoDeleteTimerChanged $messageAutoDeleteTimeChanged = null;

    /**
     * @description The group has been migrated to a supergroup with the specified identifier. This number may have more
     * than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for
     * storing this identifier
     */
    public ?bool $migrateToChatId = null;

    /**
     * @description The supergroup has been migrated from a group with the specified identifier. This number may have
     * more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting
     * it. But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe
     * for storing this identifier
     */
    public ?bool $migrateFromChatId = null;

    /**
     * @description Specified message was pinned. Note that the Message object in this field will not contain further
     * reply_to_message fields even if it is itself a reply
     */
    public ?Message $pinnedMessage = null;

    /**
     * @description Message is an invoice for a payment, information about the invoice
     */
    public ?Invoice $invoice = null;

    /**
     * @description Message is a service message about a successful payment, information about the payment
     */
    public ?SuccessfulPayment $successfulPayment = null;

    /**
     * @description The domain name of the website on which the user has logged in
     */
    public ?string $connectedWebsite = null;

    /**
     * @description Telegram Passport data
     */
    public ?PassportData $passportData = null;

    /**
     * @description Service message. A user in the chat triggered another user's proximity alert while sharing Live
     * Location
     */
    public ?ProximityAlertTriggered $proximityAlertTriggered = null;

    /**
     * @description Service message: voice chat started
     */
    public ?VoiceChatStarted $voiceChatStarted = null;

    /**
     * @description Service message: voice chat ended
     */
    public ?VoiceChatEnded $voiceChatEnded = null;

    /**
     * @description Service message: new participants invited to a voice chat
     */
    public ?VoiceChatParticipantsInvited $voiceChatParticipantsInvited = null;

    /**
     * @description Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons
     */
    public ?InlineKeyboardMarkup $replyMarkup = null;

    public function __construct(int $id, Carbon $date, Chat $chat)
    {
        $this->id = $id;
        $this->date = $date;
        $this->chat = $chat;
    }

    public static function makeFromArray(array $data): self
    {
        $entity = new static(
            $data['message_id'],
            Carbon::createFromTimestamp('@' . $data['date']),
            Chat::makeFromArray($data['chat'])
        );

        $entity->from = ! empty($data['from']) ? User::makeFromArray($data['from']) : null;
        $entity->senderChat = ! empty($data['sender_chat']) ? Chat::makeFromArray($data['sender_chat']) : null;
        $entity->forwardFrom = ! empty($data['forward_from']) ? User::makeFromArray($data['forward_from']) : null;
        $entity->forwardFromChat = ! empty($data['forward_from_chat'])
            ? Chat::makeFromArray($data['forward_from_chat'])
            : null;
        $entity->forwardFromMessageId = $data['forward_from_message_id'] ?? null;
        $entity->forwardSignature = $data['forward_signature'] ?? null;
        $entity->forwardSenderName = $data['forward_sender_name'] ?? null;
        $entity->forwardDate = ! empty($data['forward_date'])
            ? Carbon::createFromTimestamp($data['forward_date'])
            : null;
        $entity->replyToMessage = ! empty($data['reply_to_message'])
            ? static::makeFromArray($data['reply_to_message'])
            : null;
        $entity->viaBot = ! empty($data['via_bot']) ? User::makeFromArray($data['via_bot']) : null;
        $entity->editDate = ! empty($data['edit_date']) ? Carbon::createFromTimestamp($data['edit_date']) : null;
        $entity->mediaGroupId = $data['media_group_id'] ?? null;
        $entity->authorSignature = $data['author_signature'] ?? null;
        $entity->text = $data['text'] ?? null;
        $entity->entities = arrays_to_array_of_objects(
            $data['entities'] ?? [],
            MessageEntity::class
        );
        $entity->animation = ! empty($data['animation']) ? Animation::makeFromArray($data['animation']) : null;
        $entity->audio = ! empty($data['audio']) ? Audio::makeFromArray($data['audio']) : null;
        $entity->document = ! empty($data['document']) ? Document::makeFromArray($data['document']) : null;
        $entity->photo = arrays_to_array_of_objects(
            $data['photo'] ?? [],
            PhotoSize::class
        );
        $entity->sticker = ! empty($data['sticker']) ? Sticker::makeFromArray($data['sticker']) : null;
        $entity->video = ! empty($data['video']) ? Video::makeFromArray($data['video']) : null;
        $entity->videoNote = ! empty($data['video_note']) ? VideoNote::makeFromArray($data['video_note']) : null;
        $entity->voice = ! empty($data['voice']) ? Voice::makeFromArray($data['voice']) : null;
        $entity->caption = $data['caption'] ?? null;
        $entity->captionEntities = arrays_to_array_of_objects(
            $data['caption_entities'] ?? [],
            MessageEntity::class
        );
        $entity->contact = ! empty($data['contact']) ? Contact::makeFromArray($data['contact']) : null;
        $entity->dice = ! empty($data['dice']) ? Dice::makeFromArray($data['dice']) : null;
        $entity->game = ! empty($data['game']) ? Game::makeFromArray($data['game']) : null;
        $entity->poll = ! empty($data['poll']) ? Poll::makeFromArray($data['poll']) : null;
        $entity->venue = ! empty($data['venue']) ? Venue::makeFromArray($data['venue']) : null;
        $entity->location = ! empty($data['location']) ? Location::makeFromArray($data['location']) : null;
        $entity->newChatMembers = arrays_to_array_of_objects(
            $data['new_chat_members'] ?? [],
            User::class
        );
        $entity->leftChatMember = ! empty($data['left_chat_member'])
            ? User::makeFromArray($data['left_chat_member'])
            : null;
        $entity->newChatTitle = $data['new_chat_title'] ?? null;
        $entity->newChatPhoto = arrays_to_array_of_objects(
            $data['new_chat_photo'] ?? [],
            PhotoSize::class
        );
        $entity->deleteChatPhoto = $data['delete_chat_photo'] ?? null;
        $entity->groupChatCreated = $data['group_chat_created'] ?? null;
        $entity->superGroupChatCreated = $data['supergroup_chat_created'] ?? null;
        $entity->channelChatCreated = $data['channel_chat_created'] ?? null;
        $entity->messageAutoDeleteTimeChanged = ! empty($data['message_auto_delete_timer_changed'])
            ? MessageAutoDeleteTimerChanged::makeFromArray($data['message_auto_delete_timer_changed'])
            : null;
        $entity->migrateToChatId = $data['migrate_to_chat_id'] ?? null;
        $entity->migrateFromChatId = $data['migrate_from_chat_id'] ?? null;
        $entity->pinnedMessage = ! empty($data['pinned_message'])
            ? static::makeFromArray($data['pinned_message'])
            : null;
        $entity->invoice = ! empty($data['invoice']) ? Invoice::makeFromArray($data['invoice']) : null;
        $entity->successfulPayment = ! empty($data['successful_payment'])
            ? SuccessfulPayment::makeFromArray($data['successful_payment'])
            : null;
        $entity->connectedWebsite = $data['connected_website'] ?? null;
        $entity->passportData = ! empty($data['passport_data'])
            ? PassportData::makeFromArray($data['passport_data'])
            : null;
        $entity->proximityAlertTriggered = ! empty($data['proximity_alert_triggered'])
            ? ProximityAlertTriggered::makeFromArray($data['proximity_alert_triggered'])
            : null;
        $entity->voiceChatStarted = ! empty($data['voice_chat_started'])
            ? VoiceChatStarted::makeFromArray($data['voice_chat_started'])
            : null;
        $entity->voiceChatEnded = ! empty($data['voice_chat_ended'])
            ? VoiceChatEnded::makeFromArray($data['voice_chat_ended'])
            : null;
        $entity->voiceChatParticipantsInvited = ! empty($data['voice_chat_participants_invited'])
            ? VoiceChatParticipantsInvited::makeFromArray($data['voice_chat_participants_invited'])
            : null;
        $entity->replyMarkup = ! empty($data['reply_markup'])
            ? InlineKeyboardMarkup::makeFromArray($data['reply_markup'])
            : null;

        return $entity;

    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_merge(
            [
                'message_id' => $this->id,
                'date' => $this->date->getTimestamp(),
                'chat' => $this->chat->toArray(),
            ],
            clean_nullable_fields([
                'from' => $this->from ? $this->from->toArray() : null,
                'sender_chat' => $this->senderChat ? $this->senderChat->toArray() : null,
                'forward_from' => $this->forwardFrom ? $this->forwardFrom->toArray() : null,
                'forward_from_chat' => $this->forwardFromChat ? $this->forwardFromChat->toArray() : null,
                'forward_from_message_id' => $this->forwardFromMessageId,
                'forward_signature' => $this->forwardSignature,
                'forward_sender_name' => $this->forwardSenderName,
                'forward_date' => $this->forwardDate ? $this->forwardDate->getTimestamp() : null,
                'reply_to_message' => $this->replyToMessage ? $this->replyToMessage->toArray() : null,
                'via_bot' => $this->viaBot ? $this->viaBot->toArray() : null,
                'edit_date' => $this->editDate ? $this->editDate->getTimestamp() : null,
                'media_group_id' => $this->mediaGroupId,
                'author_signature' => $this->authorSignature,
                'text' => $this->text,
                'entities' => array_of_objects_to_arrays($this->entities),
                'animation' => $this->animation ? $this->animation->toArray() : null,
                'audio' => $this->audio ? $this->audio->toArray() : null,
                'document' => $this->document ? $this->document->toArray() : null,
                'photo' => array_of_objects_to_arrays($this->photo),
                'sticker' => $this->sticker ? $this->sticker->toArray() : null,
                'video' => $this->video ? $this->video->toArray() : null,
                'video_note' => $this->videoNote ? $this->videoNote->toArray() : null,
                'voice' => $this->voice ? $this->voice->toArray() : null,
                'caption' => $this->caption,
                'caption_entities' => array_of_objects_to_arrays($this->captionEntities),
                'contact' => $this->contact ? $this->contact->toArray(): null,
                'dice' => $this->dice ? $this->dice->toArray() : null,
                'game' => $this->game ? $this->game->toArray() : null,
                'poll' => $this->poll ? $this->poll->toArray() : null,
                'venue' => $this->venue ? $this->venue->toArray() : null,
                'location' => $this->location ? $this->location->toArray() : null,
                'new_chat_members' => array_of_objects_to_arrays($this->newChatMembers),
                'left_chat_member' => $this->leftChatMember ? $this->leftChatMember->toArray() : null,
                'new_chat_title' => $this->newChatTitle,
                'new_chat_photo' => array_of_objects_to_arrays($this->newChatPhoto),
                'delete_chat_photo' => $this->deleteChatPhoto,
                'group_chat_created' => $this->groupChatCreated,
                'supergroup_chat_created' => $this->superGroupChatCreated,
                'channel_chat_created' => $this->channelChatCreated,
                'message_auto_delete_timer_changed' => $this->messageAutoDeleteTimeChanged
                    ? $this->messageAutoDeleteTimeChanged->toArray()
                    : null,
                'migrate_to_chat_id' => $this->migrateToChatId,
                'migrate_from_chat_id' => $this->migrateFromChatId,
                'pinned_message' => $this->pinnedMessage ? $this->pinnedMessage->toArray() : null,
                'invoice' => $this->invoice ? $this->invoice->toArray() : null,
                'successful_payment' => $this->successfulPayment ? $this->successfulPayment->toArray() : null,
                'connected_website' => $this->connectedWebsite,
                'passport_data' => $this->passportData ? $this->passportData->toArray() : null,
                'proximity_alert_triggered' => $this->proximityAlertTriggered
                    ? $this->proximityAlertTriggered->toArray()
                    : null,
                'voice_chat_started' => $this->voiceChatStarted ? $this->voiceChatStarted->toArray() : null,
                'voice_chat_ended' => $this->voiceChatEnded ? $this->voiceChatEnded->toArray() : null,
                'voice_chat_participants_invited' => $this->voiceChatParticipantsInvited
                    ? $this->voiceChatParticipantsInvited->toArray()
                    : null,
                'reply_markup' => $this->replyMarkup
                    ? $this->replyMarkup->toArray()
                    : null,
            ])
        );
    }
}
