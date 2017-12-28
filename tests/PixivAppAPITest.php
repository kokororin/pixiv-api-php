<?php

class PixivAppAPITest extends \PHPUnit_Framework_TestCase
{
    protected $loginedInstance = null;

    public function getLoginedInstance()
    {
        if (!$this->loginedInstance instanceof PixivAppAPI) {
            $api = new PixivAppAPI();
            $api->login(getenv('PIXIV_USERNAME'), getenv('PIXIV_PASSWORD'));
            $this->loginedInstance = $api;
        }
        return $this->loginedInstance;
    }

    public function testInitialize()
    {
        $api = $this->getLoginedInstance();

        $this->assertInstanceOf('PixivAppAPI', $api);
    }

    public function testUserDetail()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_detail(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user', $result);
    }

    public function testUserIllusts()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_illusts(19983902, 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testSearchIllust()
    {
        $api = $this->getLoginedInstance();
        $result = $api->search_illust('kotori', 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testUserBookmarksIllust()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_bookmarks_illust(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testIllustDetail()
    {
        $api = $this->getLoginedInstance();
        $result = $api->illust_detail(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illust', $result);
    }

    public function testIllustComments()
    {
        $api = $this->getLoginedInstance();
        $result = $api->illust_comments(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('comments', $result);
    }

    public function testIllustRelated()
    {
        $api = $this->getLoginedInstance();
        $result = $api->illust_related(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testIllustRanking()
    {
        $api = $this->getLoginedInstance();
        $result = $api->illust_ranking('day', 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testTrendingTagsIllust()
    {
        $api = $this->getLoginedInstance();
        $result = $api->trending_tags_illust();
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('trend_tags', $result);
    }

    public function testUserFollowing()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_following(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }

    public function testUserFollower()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_follower(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }

    public function testUserMypixiv()
    {
        $api = $this->getLoginedInstance();
        $result = $api->user_mypixiv(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }
}
