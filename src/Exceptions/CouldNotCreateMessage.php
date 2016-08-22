<?php

namespace NotificationChannels\MailLift\Exceptions;

class CouldNotCreateMessage extends \Exception
{
    public static function invalidRecurrenceType($recurrenceType)
    {
        return new static("Recurrence Type `{$recurrenceType}` is invalid. It should be either `day`, `week`, `month` or `year`.");
    }
}
