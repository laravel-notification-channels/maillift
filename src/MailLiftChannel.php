<?php

namespace NotificationChannels\MailLift;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use NotificationChannels\MailLift\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;
use NotificationChannels\MailLift\Exceptions\InvalidConfiguration;

class MailLiftChannel
{
    const API_ENDPOINT = 'https://api.maillift.com/2016-04-21/letter/';

    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\MailLift\Exceptions\InvalidConfiguration
     * @throws \NotificationChannels\MailLift\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $routing = $notifiable->routeNotificationFor('MailLift')) {
            return;
        }

        $user = config('services.maillift.user');
        $key = config('services.maillift.key');

        if (is_null($key) || is_null($user)) {
            throw InvalidConfiguration::configurationNotSet();
        }

        $mailliftParameters = $notification->toMailLift($notifiable)->toArray();

        $response = $this->client->post(self::API_ENDPOINT, [
            'auth' => [$user, $key],
            'form_params' => Arr::set($mailliftParameters, 'Recipient', $routing),
        ]);

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
