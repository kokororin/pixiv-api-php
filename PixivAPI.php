<?php
/**
 * pixiv-api-php
 * Pixiv API for PHP
 *
 * @package  pixiv-api-php
 * @author   Kokororin
 * @license  MIT License
 * @version  2.1
 * @link     https://github.com/kokororin/pixiv-api-php
 */

class PixivAPI extends PixivBase
{
    /**
     * @var string
     */
    protected $api_prefix = 'https://public-api.secure.pixiv.net';

    /**
     * @var array
     */
    protected $headers = array(
        'Host' => 'public-api.secure.pixiv.net',
        'Authorization' => 'Bearer WHDWCGnwWA2C8PRfQSdXJxjXp0G6ULRaRkkd6t5B6h8',
        'User-Agent' => 'PixivIOSApp/5.8.3',
    );

    /**
     * 黑词
     *
     * @return mixed
     */
    public function bad_words()
    {
        return $this->fetch('/v1.1/bad_words.json', array(
            'method' => 'get',
            'headers' => $this->headers,
        ));
    }

    /**
     * 作品详细
     *
     * @param $illust_id
     * @return mixed
     */
    public function works($illust_id, $image_sizes = array('px_128x128', 'px_480mw', 'large'))
    {
        return $this->fetch('/v1/works/' . $illust_id . '.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'image_sizes' => implode(',', $image_sizes),
            ),
        ));
    }

    /**
     * 用户资料
     *
     * @param $author_id
     * @return mixed
     */
    public function users($author_id)
    {
        return $this->fetch('/v1/users/' . $author_id . '.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'profile_image_sizes' => 'px_170x170,px_50x50',
                'image_sizes' => 'px_128x128,small,medium,large,px_480mw',
                'include_stats' => 1,
                'include_profile' => 1,
                'include_workspace' => 1,
                'include_contacts' => 1,
            ),
        ));
    }

    /**
     * 我的订阅
     *
     * @param $show_r18
     * @param true $max_id
     * @return mixed
     */
    public function me_feeds($show_r18 = true, $max_id = null)
    {
        $body = array(
            'relation' => 'all',
            'type' => 'touch_nottext',
            'show_r18' => $show_r18,
        );
        if (!is_null($max_id)) {
            $body['max_id'] = $max_id;
        }
        return $this->fetch('/v1/me/feeds.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => $body,
        ));
    }

    /**
     * 获取收藏夹
     * publicity: public, private
     *
     * @param $page
     * @param $per_page
     * @param $publicity
     * @param array $image_sizes
     * @return mixed
     */
    public function me_favorite_works($page = 1, $per_page = 50, $publicity = 'public',
        $image_sizes = array('px_128x128', 'px_480mw', 'large')) {
        return $this->fetch('/v1/me/favorite_works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'publicity' => $publicity,
                'image_sizes' => implode(',', $image_sizes),
            ),
        ));
    }

    /**
     * 添加收藏
     * publicity: public, private
     *
     * @param $work_id
     * @param $publicity
     * @return mixed
     */
    public function me_favorite_works_add($work_id, $publicity = 'public')
    {
        return $this->fetch('/v1/me/favorite_works.json', array(
            'method' => 'post',
            'headers' => $this->headers,
            'body' => array(
                'work_id' => $work_id,
                'publicity' => $publicity,
            ),
        ));
    }

    /**
     * 删除收藏
     * publicity: public, private
     *
     * @param $ids
     * @param $publicity
     * @return mixed
     */
    public function me_favorite_works_delete($ids, $publicity = 'public')
    {
        return $this->fetch('/v1/me/favorite_works.json', array(
            'method' => 'delete',
            'headers' => $this->headers,
            'body' => array(
                'ids' => implode(',', $ids),
                'publicity' => $publicity,
            ),
        ));
    }

    /**
     * 关注的新作品 (New -> Follow)
     *
     * @param $page
     * @param $per_page
     * @param array $image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function me_following_works($page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_stats = true, $include_sanity_level = true) {
        return $this->fetch('/v1/me/following/works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'image_sizes' => implode(',', $image_sizes),
                'include_stats' > $include_stats,
                'include_sanity_level' => $include_sanity_level,
            ),
        ));
    }

    /**
     * 获取关注用户
     *
     * @param $page
     * @param $per_page
     * @param $publicity
     * @return mixed
     */
    public function me_following($page = 1, $per_page = 30, $publicity = 'public')
    {
        return $this->fetch('/v1/me/following.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'publicity' => $publicity,
            ),
        ));
    }

    /**
     * 关注用户
     * publicity:  public, private
     *
     * @param $user_id
     * @param $publicity
     * @return mixed
     */
    public function me_favorite_users_follow($user_id, $publicity = 'public')
    {
        return $this->fetch('/v1/me/favorite-users.json', array(
            'method' => 'post',
            'headers' => $this->headers,
            'body' => array(
                'target_user_id' => $user_id,
                'publicity' => $publicity,
            ),
        ));
    }

    /**
     * 解除关注用户
     *
     * @param $user_ids
     * @param $publicity
     * @return mixed
     */
    public function me_favorite_users_unfollow($user_ids, $publicity = 'public')
    {
        return $this->fetch('/v1/me/favorite-users.json', array(
            'method' => 'delete',
            'headers' => $this->headers,
            'body' => array(
                'delete_ids' => implode(',', $user_ids),
                'publicity' => $publicity,
            ),
        ));
    }

    /**
     * 用户作品列表
     *
     * @param $author_id
     * @param $page
     * @param $per_page
     * @param array $image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function users_works($author_id, $page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_stats = true, $include_sanity_level = true) {
        return $this->fetch('/v1/users/' . $author_id . '/works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'include_stats' => $include_stats,
                'include_sanity_level' => $include_sanity_level,
                'image_sizes' => implode(',', $image_sizes),
            ),
        ));
    }

    /**
     * 用户收藏
     *
     * @param $author_id
     * @param $page
     * @param $per_page
     * @param array $image_sizes
     * @param $include_sanity_level
     * @return mixed
     */
    public function users_favorite_works($author_id, $page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_sanity_level = true) {
        return $this->fetch('/v1/users/' . $author_id . '/favorite_works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'include_sanity_level' => $include_sanity_level,
                'image_sizes' => implode(',', $image_sizes),
            ),
        ));
    }

    /**
     * 用户活动
     *
     * @param $author_id
     * @param $show_r18
     * @param true $max_id
     * @return mixed
     */
    public function users_feeds($author_id, $show_r18 = true, $max_id = null)
    {
        $body = array(
            'relation' => 'all',
            'type' => 'touch_nottext',
            'show_r18' => $show_r18,
        );
        if (!is_null($max_id)) {
            $body['max_id'] = $max_id;
        }
        return $this->fetch('/v1/users/' . $author_id . '/feeds.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => $body,
        ));
    }

    /**
     * 用户关注的用户
     *
     * @param $author_id
     * @param $page
     * @param $per_page
     * @return mixed
     */
    public function users_following($author_id, $page = 1, $per_page = 30)
    {
        return $this->fetch('/v1/users/' . $author_id . '/following.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
            ),
        ));
    }

    /**
     * 排行榜/过去排行榜
     * ranking_type: [all, illust, manga, ugoira]
     * mode: [daily, weekly, monthly, rookie, original, male, female, daily_r18, weekly_r18, male_r18, female_r18, r18g]
     *       for 'illust' & 'manga': [daily, weekly, monthly, rookie, daily_r18, weekly_r18, r18g]
     *       for 'ugoira': [daily, weekly, daily_r18, weekly_r18],
     * page: [1-n]
     * date: '2015-04-01' (仅过去排行榜)
     *
     * @param $ranking_type
     * @param $mode
     * @param $page
     * @param $per_page
     * @param $date
     * @param array $image_sizes
     * @param array $profile_image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function ranking($ranking_type = 'all', $mode = 'daily', $page = 1, $per_page = 50, $date = null,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $profile_image_sizes = array('px_170x170', 'px_50x50'),
        $include_stats = true, $include_sanity_level = true) {
        $body = array(
            'mode' => $mode,
            'page' => $page,
            'per_page' => $per_page,
            'include_stats' => $include_stats,
            'include_sanity_level' => $include_sanity_level,
            'image_sizes' => implode(',', $image_sizes),
            'profile_image_sizes' => implode(',', $profile_image_sizes),
        );
        if (!is_null($date)) {
            $body['date'] = $date;
        }
        return $this->fetch('/v1/ranking/' . $ranking_type . '.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => $body,
        ));
    }

    /**
     * alias for old API ranking_all()
     *
     * @param $mode
     * @param $page
     * @param $per_page
     * @param $date
     * @param array $image_sizes
     * @param array $profile_image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function ranking_all($mode = 'daily', $page = 1, $per_page = 50, $date = null,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $profile_image_sizes = array('px_170x170', 'px_50x50'),
        $include_stats = true, $include_sanity_level = true) {
        return $this->ranking('all', $mode, $page, $per_page, $date,
            $image_sizes, $profile_image_sizes,
            $include_stats, $include_sanity_level);
    }

    /**
     * 作品搜索
     * query: 搜索的文字
     * page: 1-n
     * mode:
     *   text - 标题/描述
     *   tag - 非精确标签
     *   exact_tag - 精确标签
     *   caption - 描述
     * period (only applies to asc order):
     *   all - 所有
     *   day - 一天之内
     *   week - 一周之内
     *   month - 一月之内
     * order:
     *   desc - 新顺序
     *   asc - 旧顺序
     *
     * @param $query
     * @param $page
     * @param $per_page
     * @param $mode
     * @param $period
     * @param $order
     * @param $sort
     * @param array $types
     * @param array $image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function search_works($query, $page = 1, $per_page = 30, $mode = 'text',
        $period = 'all', $order = 'desc', $sort = 'date',
        $types = array('illustration', 'manga', 'ugoira'),
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $include_stats = true, $include_sanity_level = true) {
        return $this->fetch('/v1/search/works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'q' => $query,
                'page' => $page,
                'per_page' => $per_page,
                'period' => $period,
                'order' => $order,
                'sort' => $sort,
                'mode' => $mode,
                'types' => implode(',', $types),
                'include_stats' => $include_stats,
                'include_sanity_level' => $include_sanity_level,
                'image_sizes' => implode(',', $image_sizes),
            ),
        ));
    }

    /**
     * 最新作品 (New -> Everyone)
     *
     * @param $page
     * @param $per_page
     * @param array $image_sizes
     * @param array $profile_image_sizes
     * @param $include_stats
     * @param true $include_sanity_level
     * @return mixed
     */
    public function latest_works($page = 1, $per_page = 30,
        $image_sizes = array('px_128x128', 'px_480mw', 'large'),
        $profile_image_sizes = array('px_170x170', 'px_50x50'),
        $include_stats = true, $include_sanity_level = true) {
        return $this->fetch('/v1/works.json', array(
            'method' => 'get',
            'headers' => $this->headers,
            'body' => array(
                'page' => $page,
                'per_page' => $per_page,
                'include_stats' => $include_stats,
                'include_sanity_level' => $include_sanity_level,
                'image_sizes' => implode(',', $image_sizes),
                'profile_image_sizes' => implode(',', $profile_image_sizes),
            ),
        ));
    }

}
