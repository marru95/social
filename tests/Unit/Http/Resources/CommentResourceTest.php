<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Status;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_comment_resources_must_have_the_necessary_fields()
    {

        $comment = factory(Status::class)->create();
        $commentResource = CommentResource::make($comment)->resolve();


        $this->assertEquals(
            $comment->body,
            $commentResource['body']
        );

        $this->assertEquals(
            $comment->id,
            $commentResource['id']
        );

        $this->assertEquals(
            $comment->user->name,
            $commentResource['user_name']
        );

        $this->assertEquals(
            'https://image.shutterstock.com/image-vector/people-icon-vector-user-symbol-600w-1714434235.jpg',
            $commentResource['user_avatar']
        );
        $this->assertEquals(
            0,
            $commentResource['likes_count']
        );
        $this->assertEquals(
            false,
            $commentResource['likes_liked']
        );


    }
}
