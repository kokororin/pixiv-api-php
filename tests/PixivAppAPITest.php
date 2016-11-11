<?php

class PixivAppAPITest extends \PHPUnit_Framework_TestCase
{
    protected $username = '';
    protected $password = '';

    protected $loginedInstance = null;

    public function getLoginedInstance()
    {
        if (!$this->loginedInstance instanceof PixivAPI) {
            $api = new PixivAPI();
            $api->login($this->username, $this->password);
            $this->loginedInstance = $api;
        }
        return $this->loginedInstance;
    }

    public function testInitialize()
    {
        $api = new PixivAppAPI;

        $this->assertInstanceOf('PixivAPI', $api);
    }

    // TODO
}
