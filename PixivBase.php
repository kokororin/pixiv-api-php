<?php
/**
 * pixiv-api-php
 * Pixiv API for PHP
 *
 * @package  pixiv-api-php
 * @author   Kokororin
 * @license  MIT License
 * @version  2.0
 * @link     https://github.com/kokororin/pixiv-api-php
 */

use \Curl\Curl;

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
    protected $oauth_client_id = 'bYGKuGVw91e0NMfPGp44euvGt59s';

    /**
     * @var string
     */
    protected $oauth_client_secret = 'HP3RmkgAmEGro0gn1x9ioawQE8WMfvLXDz3ZqxpK';

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
     * 登录
     *
     * @param $user
     * @param $pwd
     * @param $refresh_token
     */
    public function login($user = null, $pwd = null, $refresh_token = null)
    {
        $request = array(
            'client_id' => $this->oauth_client_id,
            'client_secret' => $this->oauth_client_secret,
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
        $curl->setHeader('Authorization', $this->headers['Authorization']);
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
     * 获取Access Token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * 设置Access Token
     *
     * @param $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
        $this->headers['Authorization'] = 'Bearer ' . $access_token;
    }

    /**
     * 获取Refresh Token
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * 设置Refresh Token
     *
     * @param $refresh_token
     */
    public function setRefreshToken($refresh_token)
    {
        $this->refresh_token = $this->refresh_token;
    }

    /**
     * 获取认证后的信息
     *
     * @return string
     */
    public function getAuthorizationResponse()
    {
        return $this->authorization_response;
    }

    /**
     * 设置认证后的信息
     *
     * @param $authorization_response
     */
    public function setAuthorizationResponse($authorization_response)
    {
        $this->authorization_response = $authorization_response;
    }

}
