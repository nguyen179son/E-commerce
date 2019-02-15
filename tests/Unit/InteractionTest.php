<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InteractionTest extends TestCase
{


    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testAddCommentWithCorrectVideoIdAndUserId()
    {
        $data = [
            'user_id' => 1,
            'video_id' => 1,
            'data' => array('content'=>'12412312'),
        ];
        $response = $this->post('/comment', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testDeleteCommentsWithCorrectIdAndUserId()
    {
        $data = [
            'user_id' => 1,
        ];
        $response = $this->delete('/comment/12', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testDeleteCommentsWithWrongId()
    {
        $data = [
            'user_id' => 1,
        ];
        $response = $this->delete('/comment/abc', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"Comment not found\"",$response->getContent());
    }

    public function testDeleteCommentsWithCorrectIdWrongUserId()
    {
        $data = [
            'user_id' => 1231312,
        ];
        $response = $this->delete('/comment/11', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"You do not have the permission to delete this comment\"",$response->getContent());
    }

    public function testUpdateCommentsWithCorrectIdAndUserId()
    {
        $data = [
            'user_id' => 456,
            'data' => array('content'=>'12412312'),
        ];
        $response = $this->put('/comment/10', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testUpdateCommentsWithWrongId()
    {
        $data = [
            'user_id' => 1,
            'data' => array('content'=>'12412312'),
        ];
        $response = $this->put('/comment/abc', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"Comment not found\"",$response->getContent());
    }

    public function testUpdateCommentsWithCorrectIdAndWrongUserId()
    {
        $data = [
            'user_id' => 121221,
            'data' => array('content'=>'12412312'),
        ];
        $response = $this->put('/comment/10', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"You do not have the permission to edit this comment\"",$response->getContent());
    }

    public function testGetListCommentsWithCorrectId()
    {
        $data = [
            'video_id' => 1,
        ];
        $response = $this->get('/comment/list', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testLikeVideoWithCorrectUserAndVideo()
    {
        $data = [
            'user_id' => 1,
            'video_id' => 111,
        ];
        $response = $this->post('/like', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testLikeVideoWithExistedUserAndVideo()
    {
        $data = [
            'user_id' => 1,
            'video_id' => 1,
        ];
        $response = $this->post('/like', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"You liked this video\"",$response->getContent());
    }

    public function testUnlikeVideoWithCorrectUserAndVideo()
    {
        $data = [
            'user_id' => 1,
            'video_id' => 1,
        ];
        $response = $this->post('/unlike', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }

    public function testUnlikeVideoWithWrongUserAndVideo()
    {
        $data = [
            'user_id' => 111,
            'video_id' => 111,
        ];
        $response = $this->post('/unlike', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":false,\"message\":\"Content not found\"",$response->getContent());
    }


    public function testListLikes()
    {
        $data = [
            'video_id' => 1,
        ];
        $response = $this->get('/like/list', $data,array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'));
        $this->assertContains("\"success\":true",$response->getContent());
    }
}
