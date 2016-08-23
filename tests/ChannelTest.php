<?php

namespace NotificationChannels\MailLift\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\MailLift\Exceptions\CouldNotSendNotification;
use NotificationChannels\MailLift\Exceptions\InvalidConfiguration;
use NotificationChannels\MailLift\MailLiftChannel;
use NotificationChannels\MailLift\MailLiftMessage;
use Orchestra\Testbench\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function it_can_send_a_notification()
    {
        $this->app['config']->set('services.maillift.user', 'MailLiftUsername');
        $this->app['config']->set('services.maillift.key', 'MailLiftKey');
        $response = new Response(200);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->with('https://api.maillift.com/2016-04-21/letter/', Mockery::type('array'))
            ->andReturn($response);
        $channel = new MailLiftChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_is_not_configured()
    {
        $this->setExpectedException(InvalidConfiguration::class);

        $client = new Client();
        $channel = new MailLiftChannel($client);
        $channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $this->app['config']->set('services.maillift.user', 'MailLiftUsername');
        $this->app['config']->set('services.maillift.key', 'MailLiftKey');

        $response = new Response(500);
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('post')
            ->once()
            ->andReturn($response);
        $channel = new MailLiftChannel($client);

        $this->setExpectedException(CouldNotSendNotification::class);

        $channel->send(new TestNotifiable(), new TestNotification());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForMailLift()
    {
        return 'Laravel Notification Channels'.PHP_EOL.'Receiver Street 123';
    }
}


class TestNotification extends Notification
{
    public function toMailLift($notifiable)
    {
        return MailLiftMessage::create('Message body')
            ->sender('Laravel Notification Channels'.PHP_EOL.'Street 1');
    }
}
