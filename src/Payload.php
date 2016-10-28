<?php

namespace Notifier;

class Payload {
    /**
     * Payload of a notification
     * @var mixed
     */
    protected $payload;

    /**
     * Create a new payload
     * @param mixed $payload
     */
    public function __construct($payload) {
        $this->payload = $payload;
    }

    /**
     * Get string represenation of payload
     * @return mixed
     */
    public function getData() {
        return $this->payload;
    }
}
