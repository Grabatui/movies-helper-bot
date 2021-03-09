<?php

namespace App\Telegram\Response;

use App\Telegram\Exception\WrongResponseException;

class UpdateResponse implements ResponseInterface
{
    public int $updateId;

    // TODO
    public array $message = [];

    // TODO
    public array $editedMessage = [];

    // TODO
    public array $channelPost = [];

    // TODO
    public array $editedChannelPost = [];

    // TODO
    public array $inlineQuery = [];

    // TODO
    public array $chosenInlineResult = [];

    // TODO
    public array $callbackQuery = [];

    // TODO
    public array $shippingQuery = [];

    // TODO
    public array $preCheckoutQuery = [];

    // TODO
    public array $poll = [];

    // TODO
    public array $pollAnswer = [];

    public function __construct(array $rawResponse)
    {
        if ( ! $rawResponse || ! isset($rawResponse['update_id']) || ! $rawResponse['update_id']) {
            throw new WrongResponseException(json_encode($rawResponse));
        }

        $this->updateId = $rawResponse['update_id'];
        $this->message = $rawResponse['message'] ?? [];
        $this->editedMessage = $rawResponse['edited_message'] ?? [];
        $this->channelPost = $rawResponse['channel_post'] ?? [];
        $this->editedChannelPost = $rawResponse['edited_channel_post'] ?? [];
        $this->inlineQuery = $rawResponse['inline_query'] ?? [];
        $this->chosenInlineResult = $rawResponse['chosen_inline_result'] ?? [];
        $this->callbackQuery = $rawResponse['callback_query'] ?? [];
        $this->shippingQuery = $rawResponse['shipping_query'] ?? [];
        $this->preCheckoutQuery = $rawResponse['pre_checkout_query'] ?? [];
        $this->poll = $rawResponse['poll'] ?? [];
        $this->pollAnswer = $rawResponse['poll_answer'] ?? [];
    }
}
