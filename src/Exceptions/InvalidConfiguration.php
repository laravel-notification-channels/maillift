<?php

namespace NotificationChannels\MailLift\Exceptions;

class InvalidConfiguration extends \Exception
{
    public static function configurationNotSet()
    {
        return new static('In order to send notification via MailLift you need to add credentials in the `maillift` key of `config.services`.');
    }
}
