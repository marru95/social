<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanLikeCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_users_can_not_like_comments()
    {


        $comment = factory(Comment::class)->create();

        $response = $this->postJson(route('comments.likes.store', $comment));

        $response->assertStatus(401);
    }

    /** @test */

    //Un usuario autenticado puede dar like a los comentarios
    public function an_authenticated_user_can_like_comments()
    {
        $this->withoutExceptionHandling();


        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();


        $this->actingAs($user)->postJson( route('comments.likes.store', $comment));

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'status_id' => $comment->id
        ]);
    }

}
