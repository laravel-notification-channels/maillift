<?php

namespace NotificationChannels\MailLift\Test;

use DateTime;
use Illuminate\Support\Arr;
use NotificationChannels\MailLift\Exceptions\CouldNotCreateMessage;
use NotificationChannels\MailLift\MailLiftMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\MailLift\MailLiftMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();

        $this->message = new MailLiftMessage('');
    }

    /** @test */
    public function it_accepts_a_body_when_constructing_a_message()
    {
        $message = new MailLiftMessage('MailBody');

        $this->assertEquals('MailBody', Arr::get($message->toArray(), 'MessageBody'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = MailLiftMessage::create('MailBody');

        $this->assertEquals('MailBody', Arr::get($message->toArray(), 'MessageBody'));
    }

    /** @test */
    public function it_can_set_the_body()
    {
        $this->message->body('MailBody');

        $this->assertEquals('MailBody', Arr::get($this->message->toArray(), 'MessageBody'));
    }

    /** @test */
    public function it_can_set_the_sender()
    {
        $this->message->sender('MailSender');

        $this->assertEquals('MailSender', Arr::get($this->message->toArray(), 'Sender'));
    }

    /** @test */
    public function it_can_set_a_scheduled_date_from_string()
    {
        $date = new DateTime('tomorrow');
        $this->message->scheduleDelivery('tomorrow');

        $this->assertEquals($date->format('Y-m-d'), Arr::get($this->message->toArray(), 'ScheduledDelivery'));
    }

    /** @test */
    public function it_can_set_a_scheduled_date_from_datetime()
    {
        $date = new DateTime('tomorrow');
        $this->message->scheduleDelivery($date);

        $this->assertEquals($date->format('Y-m-d'), Arr::get($this->message->toArray(), 'ScheduledDelivery'));
    }

}
