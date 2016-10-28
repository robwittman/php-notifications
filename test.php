<?php
require_once('vendor/autoload.php');
require_once('src/Client.php');
require_once('src/Notifier.php');
require_once('src/Notification.php');
require_once('src/Event.php');
require_once('src/Payload.php');
require_once('src/Connection.php');

\Notifier\Notifier::init("http://localhost:3000", 'secret-key');

$uid = 12351235;
$connection = new \Notifier\Connection($uid);

$payload = [];
$event = 'custom.event';

$notification = new \Notifier\Notification($event, $payload);
\Notifier\Notifier::send($uid, $notification);
var_dump(\Notifier\Notifier::ping());
var_dump(\Notifier\Notifier::info());
