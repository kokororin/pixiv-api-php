pixiv-api-php
======
_Pixiv API for PHP (with Auth supported)_

### Installation

~~~bash
composer require kokororin/pixiv-api-php
~~~

### Example:

~~~php
$api = new PixivAPI;
$api->login("username", "password");

# get origin url
$json_result = $api->works(45455208);
$array = json_decode($json_result, true);
$illust = $array['response'][0];
printf("origin url: %s", $illust['image_urls']['small']);
~~~

## API functions

### Public-API

~~~php

    function bad_words()

    # 作品详细
    function works($illust_id)

    # 用户资料
    function users($author_id)

    # 我的订阅
    function me_feeds($show_r18 = true, $max_id = null)

    # 获取收藏夹
    function me_favorite_works($page = 1, $per_page = 50, $publicity = 'public',
        $image_sizes = array('px_128x128', 'px_480mw', 'large'))

    # 添加收藏
    # publicity:  public, private
    function me_favorite_works_add($work_id, $publicity = 'public')

    # 删除收藏
    function me_favorite_works_delete($ids, $publicity = 'public')

    # 关注用户
    # publicity:  public, private
    function me_favorite_users_follow($user_id, $publicity = 'public')

    # 用户作品
    # publicity:  public, private
    function users_works($author_id, $page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_stats = true, $include_sanity_level = true)

    # 用户收藏
    # function users_favorite_works($author_id, $page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),

    # 排行榜/过去排行榜
    # mode:
    #   daily - 每日
    #   weekly - 每周
    #   monthly - 每月
    #   male - 男性热门
    #   female - 女性热门
    #   original - 原创
    #   rookie - Rookie
    #   daily_r18 - R18每日
    #   weekly_r18 - R18每周
    #   male_r18
    #   female_r18
    #   r18g
    # page: 1-n
    # date: '2015-04-01' (仅过去排行榜)
    function ranking($ranking_type = 'all', $mode = 'daily', $page = 1, $per_page = 50, $date = null,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $profile_image_sizes = array('px_170x170', 'px_50x50'),
        $include_stats = true, $include_sanity_level = true)

    # 搜索
    # query: 搜索的文字
    # page: 1-n
    # mode:
    #   text - 标题/描述
    #   tag - 非精确标签
    #   exact_tag - 精确标签
    #   caption - 描述
    # period (only applies to asc order):  
    #   all - 所有
    #   day - 一天之内
    #   week - 一周之内
    #   month - 一月之内
    # order:
    #   desc - 新顺序
    #   asc - 旧顺序
    function search_works($query, $page = 1, $per_page = 30, $mode = 'text',
        $period = 'all', $order = 'desc', $sort = 'date',
        $types = array('illustration', 'manga', 'ugoira'),
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_stats = true, $include_sanity_level = true)

~~~

### Usage

~~~php
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

~~~