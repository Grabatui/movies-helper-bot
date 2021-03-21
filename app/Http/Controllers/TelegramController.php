<?php

namespace App\Http\Controllers;

use App\Telegram\Exception\UnknownRequestException;
use App\Telegram\Facade;
use App\Telegram\Request\SendMessageRequest;
use App\Telegram\Response\UpdateResponse;
use App\Telegram\Service;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function hears(Request $request, Service $service, Facade $facade)
    {
        $updateRequest = new UpdateResponse(
            $request->request->all()
        );

        try {
            $service->findAndHandleCommand($updateRequest);
        } catch (UnknownRequestException $exception) {
            $message = $updateRequest->message;

            if ( ! $message && $updateRequest->callbackQuery) {
                $message = $updateRequest->callbackQuery->message;
            }

            if ( ! $message) {
                return;
            }

            $facade->sendMessage(
                new SendMessageRequest($message->chat, 'Sorry! I don\'t understand :(')
            );
        }
    }
}
