pixiv-api-php
======
_Pixiv API for PHP (with Auth supported)_

### Example:

~~~php
$api = PixivAPI();
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
class PixivAPI()

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