<?php

namespace Notifier;

class Event {
    /**
     * The event we want to trigger
     * @var string
     */
    protected $event;

    /**
     * Create an events
     * @param string $event
     */
    public function __construct($event) {
        $this->event = $event;
    }

    /**
     * Return our string event for usage
     * @return string 
     */
    public function __toString() {
        return $this->event;
    }
}
