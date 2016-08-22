<?php

namespace NotificationChannels\MailLift;

use DateTime;

class MailLiftMessage
{
    /** @var string */
    protected $body;

    /** @var string */
    protected $sender;

    /** @var string|null */
    protected $scheduledDelivery;

    /**
     * @param string $body
     *
     * @return static
     */
    public static function create($body)
    {
        return new static($body);
    }

    /**
     * @param string $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * Set the letter message body.
     *
     * @param $body
     *
     * @return $this
     */
    public function body($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Set the letter message sender.
     *
     * @param $sender
     *
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the scheduled delivery date.
     *
     * @param string|DateTime $scheduledDelivery
     *
     * @return $this
     */
    public function scheduleDelivery($scheduledDelivery)
    {
        if (! $scheduledDelivery instanceof DateTime) {
            $scheduledDelivery = new DateTime($scheduledDelivery);
        }

        $this->scheduledDelivery = $scheduledDelivery->format('Y-m-d');

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'MessageBody' => $this->body,
            'Sender' => $this->sender,
            'ScheduledDelivery' => $this->scheduledDelivery,
        ];
    }
}
