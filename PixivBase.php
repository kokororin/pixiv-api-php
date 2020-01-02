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

use Curl\Curl;

abstract class PixivBase
{

    /**
     * @var string
     */
    protected $oauth_url = 'https://oauth.secure.pixiv.net/auth/token';

    /**
     * @var array
     */
    protected $headers = array(
        'Authorization' => 'Bearer WHDWCGnwWA2C8PRfQSdXJxjXp0G6ULRaRkkd6t5B6h8',
    );

    /**
     * @var string
     */
    protected $oauth_client_id = 'MOBrBDS8blbauoSck0ZfDbtuzpyT';

    /**
     * @var string
     */
    protected $oauth_client_secret = 'lsACyCD94FhDUtGTXi3QzcFE2uU1hqtDaKeqrdwj';

    /**
     * @var string
     */
    protected $hash_secret = '28c1fdd170a5204386cb1313c7077b34f83e4aaf4aa829ce78c231e05b0bae2c';

    /**
     * @var null
     */
    protected $access_token = null;

    /**
     * @var null
     */
    protected $refresh_token = null;

    /**
     * @var null
     */
    protected $authorization_response = null;

    public function __construct()
    {
        if (!in_array('curl', get_loaded_extensions())) {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }
    }

    /**
     * ログイン
     *
     * @param $user
     * @param $pwd
     * @param $refresh_token
     */
    public function login($user = null, $pwd = null, $refresh_token = null)
    {
        $local_time = date('Y-m-d') . 'T' . date('H:i:s+00:00');
        $request = array(
            'client_id' => $this->oauth_client_id,
            'client_secret' => $this->oauth_client_secret,
            'get_secure_url' => 1,
        );
        if ($user != null && $pwd != null) {
            $request = array_merge($request, array(
                'username' => $user,
                'password' => $pwd,
                'grant_type' => 'password',
            ));
        } elseif ($refresh_token != null || $this->refresh_token != null) {
            $request = array_merge($request, array(
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token || $this->refresh_token,
            ));
        } else {
            throw new Exception('login params error.');
        }
        $curl = new Curl();
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 10);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, 0);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);
        $curl->setHeader('User-Agent', 'PixivAndroidApp/5.0.64 (Android 6.0)');
        $curl->setHeader('X-Client-Time', $local_time);
        $curl->setHeader('X-Client-Hash', md5($local_time . $this->hash_secret));
        $curl->post($this->oauth_url, $request);
        $result = $curl->response;
        $curl->close();
        if (isset($result->has_error)) {
            throw new Exception('Login error: ' . $result->errors->system->message);
        }
        $this->setAuthorizationResponse($result->response);
        $this->setAccessToken($result->response->access_token);
        $this->setRefreshToken($result->response->refresh_token);
    }

    /**
     * Access Token 取得する
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Access Token セット
     *
     * @param $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        $this->headers['Authorization'] = 'Bearer ' . $access_token;
    }

    /**
     * Refresh Token 取得する
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Refresh Token セット
     *
     * @param $refresh_token
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $this->refresh_token;
    }

    /**
     * AuthorizationResponse 取得する
     *
     * @return string
     */
    public function getAuthorizationResponse()
    {
        return $this->authorization_response;
    }

    /**
     * AuthorizationResponse セット
     *
     * @param $authorization_response
     */
    public function setAuthorizationResponse($authorization_response)
    {
        $this->authorization_response = $authorization_response;
    }

    /**
     * ネットワーク要求
     *
     * @param $uri
     * @param $method
     * @param array $params
     * @return mixed
     */
    protected function fetch($uri, $options = array())
    {
        $method = isset($options['method']) ? strtolower($options['method']) : 'get';
        if (!in_array($method, array('post', 'get', 'put', 'delete'))) {
            throw new Exception('HTTP Method is not allowed.');
        }
        $body = isset($options['body']) ? $options['body'] : array();
        $headers = isset($options['headers']) ? $options['headers'] : array();
        $url = $this->api_prefix . $uri;
        foreach ($body as $key => $value) {
            if (is_bool($value)) {
                $body[$key] = ($value) ? 'true' : 'false';
            }
        }
        $curl = new Curl();
        $curl->setOpt(CURLOPT_CONNECTTIMEOUT, 10);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, 0);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);
        if (is_array($headers)) {
            foreach ($headers as $key => $value) {
                $curl->setHeader($key, $value);
            }
        }
        $curl->$method($url, $body);

        $result = $curl->response;
        $curl->close();
        $array = json_decode(json_encode($result), true);

        return $array;
    }

}
