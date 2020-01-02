<?php

class PixivAPITest extends \PHPUnit_Framework_TestCase
{
    protected $loginedInstance = null;

    public function getLoginedInstance()
    {
        if (!$this->loginedInstance instanceof PixivAPI) {
            $api = new PixivAPI();
            $api->login(getenv('PIXIV_USERNAME'), getenv('PIXIV_USERNAME'));
            $this->loginedInstance = $api;
        }
        return $this->loginedInstance;
    }

    public function testInitialize()
    {
        $api = new PixivAPI;

        $this->assertInstanceOf('PixivAPI', $api);
    }

    public function testWorks()
    {
        $api = $this->getLoginedInstance();
        $result = $api->works(46363414);
        $illust = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['caption']);
        $this->assertNotEmpty($illust['image_urls']['small']);
    }

    public function testUsers()
    {
        $api = $this->getLoginedInstance();
        $result = $api->users(1184799);
        $user = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($user['profile']['introduction']);
    }

    public function testMeFeeds()
    {
        $api = $this->getLoginedInstance();
        $result = $api->me_feeds(true);
        $ref_work = $result['response'][0]['ref_work'];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($ref_work['ref_work']['title']);
    }

    public function testMeFavoriteWorks()
    {
        $api = $this->getLoginedInstance();
        $result = $api->me_favorite_works('private');
        $illust = $result['response'][0]['work'];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['user']['name']);
        $this->assertNotEmpty($illust['title']);
        $this->assertNotEmpty($illust['image_urls']['px_480mw']);
    }

    public function testMeFollowingWorks()
    {
        $api = $this->getLoginedInstance();
        $result = $api->me_following_works();
        $illust = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['caption']);
        $this->assertNotEmpty($illust['image_urls']['small']);
    }

    public function testMeFollowing()
    {
        $api = $this->getLoginedInstance();
        $result = $api->me_following();
        $user = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($user['name']);
    }

    public function testUsersWorks()
    {
        $api = new PixivAPI;
        $result = $api->users_works(1184799);
        $illust = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['caption']);
        $this->assertNotEmpty($illust['image_urls']['large']);
    }

    public function testUsersFavoriteWorks()
    {
        $api = new PixivAPI;
        $result = $api->users_favorite_works(1184799);
        $illust = $result['response'][0]['work'];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['caption']);
        $this->assertNotEmpty($illust['image_urls']['small']);
    }

    public function testRanking()
    {
        $api = new PixivAPI;
        $result = $api->ranking('illust', 'weekly', 1);
        $illust = $result['response'][0]['works'][0]['work'];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['title']);
        $this->assertNotEmpty($illust['image_urls']['large']);
    }

    public function testSearchWorks()
    {
        $api = new PixivAPI;
        $result = $api->search_works("水遊び", 1, 'exact_tag');
        $illust = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['title']);
        $this->assertNotEmpty($illust['image_urls']['large']);
    }

    public function testLatestWorks()
    {
        $api = new PixivAPI;
        $result = $api->latest_works();
        $illust = $result['response'][0];

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('status', $result);
        $this->assertNotEmpty($illust['title']);
        $this->assertNotEmpty($illust['image_urls']['px_480mw']);
    }
}
