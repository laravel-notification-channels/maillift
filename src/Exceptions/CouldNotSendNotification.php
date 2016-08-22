<?php

namespace NotificationChannels\MailLift\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("MailLift responded with an error: `{$response->getBody()->getContents()}`");
    }
}
