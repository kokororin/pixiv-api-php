<?php

class PixivAppAPITest extends \PHPUnit_Framework_TestCase
{
    public function testInitialize()
    {
        $api = new PixivAppAPI;

        $this->assertInstanceOf('PixivAppAPI', $api);
    }

    public function testUserDetail()
    {
        $api = new PixivAppAPI();
        $result = $api->user_detail(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user', $result);
    }

    public function testUserIllusts()
    {
        $api = new PixivAppAPI();
        $result = $api->user_illusts(19983902, 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testSearchIllust()
    {
        $api = new PixivAppAPI();
        $result = $api->search_illust('kotori', 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testUserBookmarksIllust()
    {
        $api = new PixivAppAPI();
        $result = $api->user_bookmarks_illust(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testIllustDetail()
    {
        $api = new PixivAppAPI();
        $result = $api->illust_detail(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illust', $result);
    }

    public function testIllustComments()
    {
        $api = new PixivAppAPI();
        $result = $api->illust_comments(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('comments', $result);
    }

    public function testIllustRelated()
    {
        $api = new PixivAppAPI();
        $result = $api->illust_related(47527196);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testIllustRecommended()
    {
        $api = new PixivAppAPI();
        $result = $api->illust_recommended();
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testIllustRanking()
    {
        $api = new PixivAppAPI();
        $result = $api->illust_ranking('day', 1);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('illusts', $result);
    }

    public function testTrendingTagsIllust()
    {
        $api = new PixivAppAPI();
        $result = $api->trending_tags_illust();
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('trend_tags', $result);
    }

    public function testUserFollowing()
    {
        $api = new PixivAppAPI();
        $result = $api->user_following(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }

    public function testUserFollower()
    {
        $api = new PixivAppAPI();
        $result = $api->user_follower(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }

    public function testUserMypixiv()
    {
        $api = new PixivAppAPI();
        $result = $api->user_mypixiv(19983902);
        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('user_previews', $result);
    }
}
