### PHP bindings for robbybugatti/notification-server

### Example

```php
<?php
use Notifier\Notifier;
use Notifier\Notification;
use Notifier\Connection;

$url = 'http://localhost:3000';
$token = 'secret-key';
Notifier::init($url, $token);

$connection = new Connection($uid);
echo $connection->getId();
# returns 5205d501-8c51-4ae6-a603-0e9ecc3dbd75

$payload = [
    'id' => 12341324,
    'data' => [
        'test' => true,
    ]
];

$event = 'data.created';

$notification = new Notification($event, $payload);
try {
    Notifier::send($uid, $notification);
} catch(InvalidAuthorizationException $e) {
    // AUTH TOKEN invalid
} catch(InvalidRequestException $e) {
    // Your request was improperly formatted
} catch(\Exception $e) {
    // Something else happened
}

Notifier::ping();
# Pings server, and returns true or false
Notifier::info();
#returns array('name' => 'server.name', 'version' => '1.0.0')
```

For further documentation or examples [check the container repo](https://github.com/netbulls/notification-socket.io)
