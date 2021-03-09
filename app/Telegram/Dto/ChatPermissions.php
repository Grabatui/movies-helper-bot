<?php

namespace App\Telegram\Dto;

class ChatPermissions
{
    public bool $canSendMessages = true;

    public bool $canSendMediaMessages = true;

    public bool $canSendPolls = true;

    public bool $canSendOtherMessages = true;

    public bool $canAddWebPagePreviews = true;

    public bool $canChangeInfo = true;

    public bool $canInviteUsers = true;

    public bool $canPinMessages = true;
}
