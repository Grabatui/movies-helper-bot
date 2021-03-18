<?php

namespace App\Telegram\Response;

use App\Telegram\Dto\CallbackQuery;
use App\Telegram\Dto\Chat\ChatMember;
use App\Telegram\Dto\ChosenInlineResult;
use App\Telegram\Dto\Event\ChatMemberUpdated;
use App\Telegram\Dto\InlineQuery;
use App\Telegram\Dto\Message\Message;
use App\Telegram\Dto\Payment\PreCheckoutQuery;
use App\Telegram\Dto\Payment\ShippingQuery;
use App\Telegram\Dto\Poll\Poll;
use App\Telegram\Dto\Poll\PollAnswer;
use App\Telegram\Exception\WrongResponseException;

/**
 * @description This object represents an incoming update. At most one of the optional parameters can be present in any
 * given update
 */
class UpdateResponse implements ResponseInterface
{
    /**
     * @description The update's unique identifier. Update identifiers start from a certain positive number and increase
     * sequentially. This ID becomes especially handy if you're using Webhooks, since it allows you to ignore repeated
     * updates or to restore the correct update sequence, should they get out of order. If there are no new updates for
     * at least a week, then identifier of the next update will be chosen randomly instead of sequentially
     */
    public int $updateId;

    /**
     * @description New incoming message of any kind — text, photo, sticker, etc
     */
    public ?Message $message = null;

    /**
     * @description New version of a message that is known to the bot and was edited
     */
    public ?Message $editedMessage = null;

    /**
     * @description New incoming channel post of any kind — text, photo, sticker, etc
     */
    public ?Message $channelPost = null;

    /**
     * @description New version of a channel post that is known to the bot and was edited
     */
    public ?Message $editedChannelPost = null;

    /**
     * @description New incoming inline query
     */
    public ?InlineQuery $inlineQuery = null;

    /**
     * @description The result of an inline query that was chosen by a user and sent to their chat partner. Please see
     * our documentation on the feedback collecting for details on how to enable these updates for your bot
     */
    public ?ChosenInlineResult $chosenInlineResult = null;

    /**
     * @description New incoming callback query
     */
    public ?CallbackQuery $callbackQuery = null;

    /**
     * @description New incoming shipping query. Only for invoices with flexible price
     */
    public ?ShippingQuery $shippingQuery = null;

    /**
     * @description New incoming pre-checkout query. Contains full information about checkout
     */
    public ?PreCheckoutQuery $preCheckoutQuery = null;

    /**
     * @description New poll state. Bots receive only updates about stopped polls and polls, which are sent by the bot
     */
    public ?Poll $poll = null;

    /**
     * @description A user changed their answer in a non-anonymous poll. Bots receive new votes only in polls that were
     * sent by the bot itself
     */
    public ?PollAnswer $pollAnswer = null;

    /**
     * @description The bot's chat member status was updated in a chat. For private chats, this update is received only
     * when the bot is blocked or unblocked by the user
     */
    public ?ChatMemberUpdated $myChatMember = null;

    /**
     * @description A chat member's status was updated in a chat. The bot must be an administrator in the chat and must
     * explicitly specify “chat_member” in the list of allowed_updates to receive these updates
     */
    public ?ChatMemberUpdated $chatMember = null;

    public function __construct(array $rawResponse)
    {
        if ( ! $rawResponse || ! isset($rawResponse['update_id']) || ! $rawResponse['update_id']) {
            throw new WrongResponseException(json_encode($rawResponse));
        }

        $this->updateId = $rawResponse['update_id'];

        $this->message = ! empty($rawResponse['message'])
            ? Message::makeFromArray($rawResponse['message'])
            : null;
        $this->editedMessage = ! empty($rawResponse['edited_message'])
            ? Message::makeFromArray($rawResponse['edited_message'])
            : null;
        $this->channelPost = ! empty($rawResponse['channel_post'])
            ? Message::makeFromArray($rawResponse['channel_post'])
            : null;
        $this->editedChannelPost = ! empty($rawResponse['edited_channel_post'])
            ? Message::makeFromArray($rawResponse['edited_channel_post'])
            : null;
        $this->inlineQuery = ! empty($rawResponse['inline_query'])
            ? InlineQuery::makeFromArray($rawResponse['inline_query'])
            : null;
        $this->chosenInlineResult = ! empty($rawResponse['chosen_inline_result'])
            ? ChosenInlineResult::makeFromArray($rawResponse['chosen_inline_result'])
            : null;
        $this->callbackQuery = ! empty($rawResponse['callback_query'])
            ? CallbackQuery::makeFromArray($rawResponse['callback_query'])
            : null;
        $this->shippingQuery = ! empty($rawResponse['shipping_query'])
            ? ShippingQuery::makeFromArray($rawResponse['shipping_query'])
            : null;
        $this->preCheckoutQuery = ! empty($rawResponse['pre_checkout_query'])
            ? PreCheckoutQuery::makeFromArray($rawResponse['pre_checkout_query'])
            : null;
        $this->poll = ! empty($rawResponse['poll'])
            ? Poll::makeFromArray($rawResponse['poll'])
            : null;
        $this->pollAnswer = ! empty($rawResponse['poll_answer'])
            ? PollAnswer::makeFromArray($rawResponse['poll_answer'])
            : null;
        $this->myChatMember = ! empty($rawResponse['my_chat_member'])
            ? ChatMember::makeFromArray($rawResponse['my_chat_member'])
            : null;
        $this->chatMember = ! empty($rawResponse['chat_member'])
            ? ChatMember::makeFromArray($rawResponse['chat_member'])
            : null;
    }

    public function toArray()
    {
        return array_merge(
            [
                'update_id' => $this->updateId,
            ],
            clean_nullable_fields([
                'message' => $this->message ? $this->message->toArray() : null,
                'edited_message' => $this->editedMessage ? $this->editedMessage->toArray() : null,
                'channel_post' => $this->channelPost ? $this->channelPost->toArray() : null,
                'edited_channel_post' => $this->editedChannelPost ? $this->editedChannelPost->toArray() : null,
                'inline_query' => $this->inlineQuery ? $this->inlineQuery->toArray() : null,
                'chosen_inline_result' => $this->chosenInlineResult ? $this->chosenInlineResult->toArray() : null,
                'callback_query' => $this->callbackQuery ? $this->callbackQuery->toArray() : null,
                'shipping_query' => $this->shippingQuery ? $this->shippingQuery->toArray() : null,
                'pre_checkout_query' => $this->preCheckoutQuery ? $this->preCheckoutQuery->toArray() : null,
                'poll' => $this->poll ? $this->poll->toArray() : null,
                'poll_answer' => $this->pollAnswer ? $this->pollAnswer->toArray() : null,
                'my_chat_member' => $this->myChatMember ? $this->myChatMember->toArray() : null,
                'chat_member' => $this->chatMember ? $this->chatMember->toArray() : null,
            ])
        );
    }
}
