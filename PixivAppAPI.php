<?php
/**
 * pixiv-api-php
 * PixivApp API for PHP
 *
 * @package  pixiv-api-php
 * @author   Kokororin
 * @license  MIT License
 * @version  2.0
 * @link     https://github.com/kokororin/pixiv-api-php
 */
use \Curl\Curl;

class PixivAppAPI extends PixivBase
{
    /**
     * @var string
     */
    protected $api_prefix = 'https://app-api.pixiv.net';

    /**
     * @var string
     */
    protected $api_filter='for_ios';

    /**
     * @var array
     */
    protected $headers = array(
        'Host' => 'public-api.secure.pixiv.net',
        'Authorization' => 'Bearer WHDWCGnwWA2C8PRfQSdXJxjXp0G6ULRaRkkd6t5B6h8',
        'User-Agent' => 'PixivIOSApp/5.8.3',
    );

    public function search_illust($query, $page = 1, $search_target = 'partial_match_for_tags', $sort = 'date_desc')
    {
        return $this->fetch_from_url('/v1/search/illust', 'GET', array(
            'word' => $query,
            'search_target' => $search_target,
            'sort' => $sort,
            'offset' => ($page - 1) * 30,
            'filter' => 'for_ios',
        ));
    }

    // TODO 

    /**
     *
     * @param $uri
     * @param $method
     * @param array $params
     * @return mixed
     */
    protected function fetch_from_url($uri, $method, $params = array())
    {
        $method = strtolower($method);
        if (!in_array($method, array('post', 'get', 'put', 'delete'))) {
            throw new Exception('HTTP Method is not allowed.');
        }
        $url = $this->api_prefix . $uri;
        foreach ($params as $key => $value) {
            if (is_bool($value)) {
                $params[$key] = ($value) ? 'true' : 'false';
            }
        }
        $curl = new Curl();
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 10);
        $curl->setHeader('Host', $this->headers['Host']);
        $curl->setHeader('Authorization', $this->headers['Authorization']);
        $curl->setHeader('User-Agent', $this->headers['User-Agent']);
        $curl->$method($url, $params);

        $result = $curl->response;
        $curl->close();
        $array = json_decode(json_encode($result), true);

        return $array;
    }
}
