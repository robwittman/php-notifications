<?php

namespace Notifier;

use Ramsey\Uuid\Uuid;
use Notifier\Notifier;
class Connection {
    /**
     * UUID for the connectionId
     *
     * Used by JS clients to connect to socket server
     *
     * @var string
     */
    protected $connectionId;

    /**
     * Identifier to register socket connection on behalf of
     * @var string|integer
     */
    protected $identifier;

    /**
     * Create a new connection
     * @param string|integer $identifier
     */
    public function __construct($identifier) {
        $this->identifier = $identifier;
        $connectionId = Uuid::uuid4();

        // Get our API instance, and create the connection
        $instance = Notifier::instance();
        $instance->getClient()->put("api/{$identifier}/register?connectionId={$connectionId}");
        $this->connectionId = $connectionId;
    }

    /**
     * Get our connection ID
     * @return string
     */
    public function getId() {
        return $this->connectionId;
    }
}
