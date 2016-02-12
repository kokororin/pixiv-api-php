<?php
/**
 * pixiv-api-php
 * Pixiv API for PHP
 *
 * @package  pixiv-api-php
 * @author   Kokororin
 * @license  MIT License
 * @version  1.0.0
 * @link     https://github.com/kokororin/pixiv-api-php
 */
class PixivAPI
{
    const API_PREFIX = 'https://public-api.secure.pixiv.net';
    const CURL_REFERER = 'http://spapi.pixiv.net/';
    const CURL_USERAGENT = 'User-Agent: PixivIOSApp/5.6.0';
    const CURL_HOST = 'Host: public-api.secure.pixiv.net';
    const CURL_AUTHORIZATION = 'Authorization: Bearer WHDWCGnwWA2C8PRfQSdXJxjXp0G6ULRaRkkd6t5B6h8';

    protected $params = array();

    public function __construct()
    {
        if (!in_array('curl', get_loaded_extensions()))
        {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
        $this->init_params();
    }

    protected function init_params()
    {
        $this->params = array(
            'per_page' => 50,
            'page' => 1,
            'mode' => 'daily',
            'image_sizes' => 'px_128x128,px_480mw,large',
            'profile_image_sizes' => 'px_170x170,px_50x50',
            'q' => '',
            'order' => 'desc',
            'sort' => 'date',
        );
    }

    public function per_page($per_page)
    {
        $this->params['per_page'] = $per_page;
        return $this;
    }

    public function page($page)
    {
        $this->params['page'] = $page;
        return $this;
    }

    public function mode($mode)
    {
        $this->params['mode'] = $mode;
        return $this;
    }

    public function image_sizes($image_sizes)
    {
        $this->params['image_sizes'] = $image_sizes;
        return $this;
    }

    public function profile_image_sizes($profile_image_sizes)
    {
        $this->params['profile_image_sizes'] = $profile_image_sizes;
        return $this;
    }

    public function q($q)
    {
        $this->params['q'] = $q;
        return $this;
    }

    public function order($order)
    {
        $this->params['order'] = $order;
        return $this;
    }

    public function sort($sort)
    {
        $this->params['sort'] = $sort;
        return $this;
    }

    public function ranking()
    {
        $result = $this->fetch_from_url('/v1/ranking/all', array(
            'image_sizes' => $this->params['image_sizes'],
            'include_stats' => 'true',
            'page' => $this->params['page'],
            'profile_image_sizes' => $this->params['profile_image_sizes'],
            'mode' => $this->params['mode'],
            'include_sanity_level' => 'true',
            'per_page' => $this->params['per_page'],
        ));
        $this->init_params();
        return $result;
    }

    public function search()
    {
        $result = $this->fetch_from_url('/v1/search/works.json', array(
            'image_sizes' => $this->params['image_sizes'],
            'period' => 'all',
            'include_stats' => 'true',
            'page' => $this->params['page'],
            'order' => $this->params['order'],
            'q' => $this->params['q'],
            'sort' => $this->params['sort'],
            'profile_image_sizes' => $this->params['profile_image_sizes'],
            'mode' => $this->params['mode'],
            'include_sanity_level' => 'true',
            'per_page' => $this->params['per_page'],
        ));
        $this->init_params();
        return $result;
    }

    protected function fetch_from_url($uri, $params = array())
    {
        $url = self::API_PREFIX . $uri . '?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            self::CURL_HOST,
            self::CURL_AUTHORIZATION,
            self::CURL_USERAGENT,
        ));
        curl_setopt($ch, CURLOPT_REFERER, self::CURL_REFERER);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
