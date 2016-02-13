<?php
require dirname(__FILE__) . '/pixiv.php';

$api = new PixivAPI();

$api->login('username', 'password');

echo $api->search_works('ラブライブ');

echo $api->works(55252323);
