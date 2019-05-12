<?php
require "./trello-api.php";
$key = 'key';
$token = 'token';
$trello = new trello_api($key, $token);

$data = $trello->request('GET', ('member/me/boards'));

echo '<pre>';
print_r($data);
echo '</pre>';