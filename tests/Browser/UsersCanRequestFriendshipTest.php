<?php

namespace Tests\Browser;

use App\Models\Friendship;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanRequestFriendshipTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     *
     * @test
     * @throws \Throwable
     */
    public function senders_can_create_and_delete_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($sender)
                    ->visit(route('users.show', $recipient))
                    ->press('@request-friendship')
                    ->waitForText('Cancelar solicitud')
                    ->assertSee('Cancelar solicitud')
                    ->visit(route('users.show', $recipient))
                    ->assertSee('Cancelar solicitud')
                    ->press('@request-friendship')
                     ->waitForText('Solicitar amistad')
                     ->assertSee('Solicitar amistad')

            ;
        });

    }

    /**
     *
     * @test
     * @throws \Throwable
     */
    public function recipients_can_accept_friendship_requests()
    {
        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();


        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->assertSee($sender->name)
                ->press('@accept-friendship')
                ->waitForText('son amigos')
                ->assertSee('son amigos')
                ->visit(route('accept-friendships.index'))
                ->assertSee('son amigos')
            ;
        });

    }

    /**
     *
     * @test
     * @throws \Throwable
     */
    public function recipients_can_deny_friendship_requests()
    {


        $sender = factory(User::class)->create();
        $recipient = factory(User::class)->create();


        Friendship::create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);

        $this->browse(function (Browser $browser) use ($sender, $recipient) {
            $browser->loginAs($recipient)
                ->visit(route('accept-friendships.index'))
                ->assertSee($sender->name)
                ->press('@deny-friendship')
                ->waitForText('Solicitud denegada')
                ->assertSee('Solicitud denegada')
                ->visit(route('accept-friendships.index'))
                ->assertSee('Solicitud denegada')
            ;
        });

    }

}
