<?php

namespace Notifier;

use \Notifier\Client;
use \Notifier\Notification;
use \Notifier\Connection;

class Notifier {

    /**
     * URL of the servers to send events to
     * @var string
     */
    protected static $uri = 'http://localhost';

    /**
     * Token to use for authentication
     * @var sriing
     */
    protected static $auth_token;

    /**
     * HTTP Client
     * @var Notifier\Client;
     */
    protected $client;

    /**
     * Placeholdr for our singleton instance
     * @var [type]
     */
    protected static $instance;

    /**
     * Create a neww Notifier API instance
     * @param Client $client
     */
    private function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Get instantiated client
     * @return Client $client
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * Fetch the Notifier instance
     * @return Notifier
     */
    public static function instance() {
        return self::$instance;
    }

    /**
     * Set a Notifier instance
     * @param Notifier $instance
     */
    public static function setInstance(Notifier $instance) {
        static::$instance = $instance;
    }

    /**
     * Initialize a Notifier instance
     * @param  string $url        Base URL of the server
     * @param  string $auth_token
     * @return Notifier
     */
    public static function init($url, $auth_token) {
        $notif = new static(new Client($url, $auth_token));
        static::setInstance($notif);

        return $notif;
    }

    /**
     * Create a new notification
     * @param  string|integer  $identifier
     * @param  Notification $notification
     * @return boolean
     */
    public static function send($identifier, Notification $notification) {
        return self::instance()->getClient()->post(
            "api/{$identifier}/push",
            [
                'payload' => $notification->getPayload()
            ],
            [
                'X-NOTIF-EVENT' => $notification->getEvent(),
                'Content-Type'  => 'application/json'
            ]);
    }

    /**
     * Get name and version of the server
     * @return stdClass
     */
    public static function info() {
        return self::instance()->getClient()->get('api/status/info');
    }

    /**
     * Ping the server
     *
     * @return boolean
     */
    public static function ping() {
        return self::instance()->getClient()->get('api/status/ping');
    }
}
