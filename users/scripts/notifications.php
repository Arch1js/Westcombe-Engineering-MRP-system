<?php
require(dirname(__FILE__).'/../../vendor/autoload.php');
$pusher = new Pusher('fcd14057ed504b2df470', '6d5f4dd9828ccff940cb', '228977');

$data['message'] = 'hello world';
$pusher->trigger('my_channel', 'my_event', $data);
?>
