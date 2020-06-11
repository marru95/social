<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class UsersCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws Throwable
     */
    public function users_can_create_statuses()
    {
        $user=factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user){
            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body', 'Mi primer estado') // <input name="body">
                    ->press('#create-status')
                    ->waitForText('Mi primer estado')
                    ->assertSee('Mi primer estado')
                    ->assertSee($user->name)
            ;
        });
    }

    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws Throwable
     */
    public function users_can_see_statuses_in_real_time()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->browse(function (Browser $browser1, $browser2) use ($user1, $user2){
            $browser1->loginAs($user1)
                     ->visit('/');

            $browser2->loginAs($user2)
                ->visit('/')
                ->type('body', 'Mi primer estado') // <input name="body">
                ->press('#create-status')
                ->waitForText('Mi primer estado')
                ->assertSee('Mi primer estado')
                ->assertSee($user2->name)
            ;

            $browser1->waitForText('Mi primer estado')
                ->assertSee('Mi primer estado')
                ->assertSee($user2->name);
        });
    }
}
