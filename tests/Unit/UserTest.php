<?php

namespace Tests\Unit;

use App\Models\Status;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function route_key_name_is_set_to_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name', $user->getRouteKeyName());
    }

    /** @test */
    public function user_has_link_to_their_profile()
    {
        $user = factory(User::class)->make();

        $this->assertEquals(route('users.show', $user), $user->link());
    }

    /** @test */
    public function user_has_an_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('https://image.shutterstock.com/image-vector/people-icon-vector-user-symbol-600w-1714434235.jpg', $user->avatar());
        $this->assertEquals('https://image.shutterstock.com/image-vector/people-icon-vector-user-symbol-600w-1714434235.jpg', $user->avatar);

    }

    /** @test */
    public function a_users_has_many_statuses()
    {
        $user = factory(User::class)->create();
        factory(Status::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Status::class, $user->statuses->first());

    }



}
