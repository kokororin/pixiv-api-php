<?php
require dirname(__FILE__) . '/pixiv.php';

$api = new PixivAPI();

$api->login('username', 'password');

# 作品详细 PAPI.works
$result = $api->works(46363414);
print_r($result);
$illust = $result['response'][0];
printf( ">>> %s, origin url: %u" , $illust['caption'], $illust['image_urls']['small']);

# 用户资料 PAPI.users
$result = $api->users(1184799);
print_r($result);
$user = $result['response'][0];
print_r($user['profile']['introduction']);

# 我的订阅 PAPI.me_feeds
$result = $api->me_feeds(true);
print_r($result);
$ref_work = $result['response'][0]['ref_work'];
print_r(['ref_work']['title']);

# 我的收藏列表(private) PAPI.me_favorite_works
$result = $api->me_favorite_works('private');
print_r($result);
$illust = $result['response'][0]['work'];
printf("[%s] %u: %v" , $illust['user']['name'], $illust['title'], $illust['image_urls']['px_480mw']);

# 关注的新作品[New -> Follow] PAPI.me_following_works
$result = $api->me_following_works();
print_r($result);
$illust = $result['response'][0];
printf(">>> %s, origin url: %u" , $illust['caption'], $illust['image_urls']['small']);

# 我关注的用户 PAPI.me_following
$result = $api->me_following();
print_r($result);
$user = $result['response'][0];
print_r($user['name']);

# 用户作品 PAPI.users_works
$result = $api->users_works(1184799);
print_r($result);
$illust = $result['response'][0];
printf(">>> %s, origin url: %u" , $illust['caption'], $illust['image_urls']['large']);

# 用户收藏 PAPI.users_favorite_works
$result = $api->users_favorite_works(1184799);
print_r($result);
$illust = $result['response'][0]['work'];
printf(">>> %s origin url: %u" , $illust['caption'], $illust['image_urls']['small']);

# 获取收藏夹 PAPI.me_favorite_works
$result = $api->me_favorite_works();
print_r($result);
$ids = $result['response'][0]['id'];

# 添加收藏 PAPI.me_favorite_works_add
$result = $api->me_favorite_works_add(46363414);
print_r($result);

# 删除收藏 PAPI.me_favorite_works_delete
$result = $api->me_favorite_works_delete($ids);
print_r($result);

# 关注用户 PAPI.me_favorite_users_follow
$result = $api->me_favorite_users_follow(1184799);
print_r($result);

# 排行榜 PAPI.ranking(illust)
$result = $api.ranking('illust', 'weekly', 1);
print_r($result);
$illust = $result['response'][0]['works'][0]['work'];
printf(">>> %s origin url: %u" ,$illust['title'], $illust['image_urls']['large']);

# 过去排行榜 PAPI.ranking(all, 2015-05-01)
$result = $api->ranking('all', 'daily', 1, '2015-05-01');
print_r($result);
$illust = $result['response'][0]['works'][0]['work'];
printf(">>> %s origin url: %u" , $illust['title'], $illust['image_urls']['large']);

# 标题(text)/标签(exact_tag)搜索 PAPI.search_works
#$result = $api->search_works("五航戦 姉妹", 1, 'text');
$result = $api->search_works("水遊び", 1, 'exact_tag');
print_r($result);
$illust = $result['response'][0];
printf(">>> %s origin url: %u" , $illust['title'], $illust['image_urls']['large']);

# 最新作品列表[New -> Everyone] PAPI.latest_works
$result = $api->latest_works();
print_r($result);
$illust = $result['response'][0];
printf(">>> %s url: %u" , $illust['title'], $illust['image_urls']['px_480mw']);


