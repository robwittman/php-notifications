<?php

namespace Notifier;

use Notifier\Event;
use Notifier\Payload;

class Notification {
    protected $payload;
    protected $event;

    public function __construct($event, $payload) {
        $this->event = new Event($event);
        $this->payload = new Payload($payload);
    }

    public function getPayload() {
        return $this->payload->getData();
    }

    public function getEvent() {
        return (string) $this->event;
    }
}
