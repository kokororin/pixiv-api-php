<?php
require dirname(__FILE__) . '/pixiv.php';

$api = new PixivAPI();

echo $api->image_sizes('px_128x128,px_480mw,large')
    ->mode('daily_r18')
    ->per_page(30)
    ->page(1)
    ->profile_image_sizes('px_170x170,px_50x50')
    ->ranking();

echo $api->image_sizes('px_128x128,px_480mw,large')
    ->mode('exact_tag')
    ->per_page(30)
    ->page(1)
    ->profile_image_sizes('px_170x170,px_50x50')
    ->q('ラブライブ')
    ->search();
