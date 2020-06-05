<?php

namespace Tests\Unit\Models;

use App\Models\Like;
use App\User;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function a_comment_belongs_to_a_user()
    {

        $comment = factory(Comment::class)->create();



        $this->assertInstanceOf(User::class, $comment->user);
    }


    /** @test */
    public function a_comment_morph_has_many_likes()
    {

        $comment = factory(Comment::class)->create();

        factory(Like::class)->create([
            'likeable_id' => $comment->id,          //Id
            'likeable_type' => get_class($comment), // App\\Models\Comment
        ]);

        $this->assertInstanceOf(Like::class, $comment->likes->first());

    }
}
