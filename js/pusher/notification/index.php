<?php

require(dirname(__FILE__).'/../vendor/autoload.php');

require('../vendor/pusher/pusher-php-server/lib/Pusher.php');

$app_id = '228977';
$app_key = 'fcd14057ed504b2df470';
$app_secret = '6d5f4dd9828ccff940cb';

$pusher = new Pusher($app_key, $app_secret, $app_id, array('cluster' => 'eu'));

$text = htmlspecialchars($_POST['message']);

$data['message'] = $text;
$pusher->trigger('notifications', 'new_notification', $data);

?>
