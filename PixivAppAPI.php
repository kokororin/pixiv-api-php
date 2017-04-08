<?php
/**
 * pixiv-api-php
 * PixivApp API for PHP
 *
 * @package  pixiv-api-php
 * @author   Kokororin
 * @license  MIT License
 * @version  2.1
 * @link     https://github.com/kokororin/pixiv-api-php
 */

class PixivAppAPI extends PixivBase
{
    /**
     * @var string
     */
    protected $api_prefix = 'https://app-api.pixiv.net';

    /**
     * @var string
     */
    protected $api_filter = 'for_ios';

    /**
     * @var array
     */
    protected $headers = array(
        'Authorization' => 'Bearer WHDWCGnwWA2C8PRfQSdXJxjXp0G6ULRaRkkd6t5B6h8',
    );

    protected $noneAuthHeaders = array(
        'User-Agent' => 'PixivIOSApp/6.7.1 (iOS 10.3.1; iPhone8,1)',
        'App-OS' => 'ios',
        'App-OS-Version' => '10.3.1',
        'App-Version' => '6.7.1',
    );

    /**
     * ユーザーの詳細
     *
     * @param  string $user_id
     * @return array
     */
    public function user_detail($user_id)
    {
        return $this->fetch('/v1/user/detail', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'filter' => $this->api_filter,
            ),
        ));
    }

    /**
     * ユーザーのイラスト
     *
     * @param  string  $user_id
     * @param  integer $page
     * @param  string  $type
     * @return array
     */
    public function user_illusts($user_id, $page = 1, $type = 'illust')
    {
        return $this->fetch('/v1/user/illusts', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'type' => $type,
                'offset' => ($page - 1) * 30,
                'filter' => $this->api_filter,
            ),
        ));
    }

    /**
     * 検索イラスト
     *
     * @param  string  $query
     * @param  integer $page
     * @param  string  $search_target
     *                     partial_match_for_tags
     *                     exact_match_for_tags
     *                     title_and_caption
     * @param  string  $sort
     *                     date_desc
     *                     date_asc
     * @param  string  $duration
     *                     within_last_day
     *                     within_last_week
     *                     within_last_month
     * @return array
     */
    public function search_illust($word, $page = 1, $search_target = 'partial_match_for_tags', $sort = 'date_desc', $duration = null)
    {
        $body = array(
            'word' => $word,
            'search_target' => $search_target,
            'sort' => $sort,
            'offset' => ($page - 1) * 30,
            'filter' => $this->api_filter,
        );
        if ($duration != null) {
            $body['duration'] = $duration;
        }
        return $this->fetch('/v1/search/illust', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => $body,
        ));
    }

    /**
     * ユーザーのマーク付きイラスト
     *
     * @param  string $user_id
     * @param  string $restrict
     * @return array
     */
    public function user_bookmarks_illust($user_id, $restrict = 'public')
    {
        return $this->fetch('/v1/user/bookmarks/illust', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'restrict' => $restrict,
                'filter' => $this->api_filter,
            ),
        ));
    }

    /**
     * イラストの詳細
     *
     * @param  string $illust_id
     * @return array
     */
    public function illust_detail($illust_id)
    {
        return $this->fetch('/v1/illust/detail', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'illust_id' => $illust_id,
            ),
        ));
    }

    /**
     * イラストのコメント
     *
     * @param  string $illust_id
     * @param  integer $page
     * @param  boolean $include_total_comments
     * @return array
     */
    public function illust_comments($illust_id, $page = 1, $include_total_comments = true)
    {
        return $this->fetch('/v1/illust/comments', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'illust_id' => $illust_id,
                'offset' => ($page - 1) * 30,
                'include_total_comments' => true,
            ),
        ));
    }

    /**
     * 関連イラストリスト
     *
     * @param  string $illust_id
     * @param  array $seed_illust_ids
     * @return array
     */
    public function illust_related($illust_id, $seed_illust_ids = null)
    {
        $body = array(
            'illust_id' => $illust_id,
            'filter' => $this->api_filter,
        );
        if (is_array($seed_illust_ids)) {
            $body['seed_illust_ids[]'] = $seed_illust_ids;
        }
        return $this->fetch('/v2/illust/related', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => $body,
        ));
    }

    /**
     * お勧めのイラスト一覧
     *
     * @param  string  $content_type
     * @param  integer $page
     * @param  boolean $include_ranking_label
     * @param  string  $max_bookmark_id_for_recommend
     * @param  string  $min_bookmark_id_for_recent_illust
     * @param  boolean  $include_ranking_illusts
     * @param  array  $bookmark_illust_ids
     * @return array
     */
    public function illust_recommended($content_type = 'illust',
        $page = 1,
        $include_ranking_label = true,
        $max_bookmark_id_for_recommend = null,
        $min_bookmark_id_for_recent_illust = null,
        $include_ranking_illusts = null,
        $bookmark_illust_ids = null) {
        $body = array(
            'content_type' => $content_type,
            'include_ranking_label' => $include_ranking_label,
            'offset' => ($page - 1) * 30,
            'filter' => $this->api_filter,
        );
        if ($max_bookmark_id_for_recommend != null) {
            $body['max_bookmark_id_for_recommend'] = $max_bookmark_id_for_recommend;
        }
        if ($min_bookmark_id_for_recent_illust != null) {
            $body['min_bookmark_id_for_recent_illust'] = $min_bookmark_id_for_recent_illust;
        }
        if ($include_ranking_illusts != null) {
            $body['include_ranking_illusts'] = $include_ranking_illusts;
        }
        if (is_array($bookmark_illust_ids)) {
            $body['bookmark_illust_ids'] = $bookmark_illust_ids;
        }
        return $this->fetch('/v1/illust/recommended-nologin', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => $body,
        ));
    }

    /**
     * ランキングイラスト一覧
     *
     * @param  string  $mode
     *                         day
     *                         week
     *                         month
     *                         day_male
     *                         day_female
     *                         week_original
     *                         week_rookie
     *                         day_manga
     * @param  integer $page
     * @param  string  $date  YYYY-MM-DD
     * @return [type]
     */
    public function illust_ranking($mode = 'day', $page = 1, $date = null)
    {
        $body = array(
            'mode' => $mode,
            'offset' => ($page - 1) * 30,
            'filter' => $this->api_filter,
        );
        if ($date != null) {
            $body['date'] = $date;
        }
        return $this->fetch('/v1/illust/ranking', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => $body,
        ));
    }

    /**
     * トレンドタグ
     *
     * @return array
     */
    public function trending_tags_illust()
    {
        return $this->fetch('/v1/trending-tags/illust', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'filter' => $this->api_filter,
            ),
        ));
    }

    /**
     * ユーザーのフォロー
     * @param  string  $user_id
     * @param  string  $restrict
     * @param  integer $page
     * @return array
     */
    public function user_following($user_id, $restrict = 'public', $page = 1)
    {
        return $this->fetch('/v1/user/following', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'restrict' => $restrict,
                'offset' => ($page - 1) * 30,
            ),
        ));
    }

    /**
     * ユーザーのフォロワー
     * @param  string  $user_id
     * @param  integer $page
     * @return array
     */
    public function user_follower($user_id, $page = 1)
    {
        return $this->fetch('/v1/user/follower', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'filter' => $this->api_filter,
                'offset' => ($page - 1) * 30,
            ),
        ));
    }

    /**
     * ユーザーのマイピク
     * @param  string   $user_id
     * @param  integer  $page
     * @return array
     */
    public function user_mypixiv($user_id, $page = 1)
    {
        return $this->fetch('/v1/user/mypixiv', array(
            'method' => 'get',
            'headers' => $this->noneAuthHeaders,
            'body' => array(
                'user_id' => $user_id,
                'offset' => ($page - 1) * 30,
            ),
        ));
    }

}
