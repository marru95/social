<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    //los_invitados_no_pueden_crear_estados
    function guests_users_can_not_create_Statuses()
    {
        $response = $this->post(route('statuses.store'), ['body' => 'Mi primer status']);


        $response-> assertRedirect('login');
    }

    //Un usuario autenticado puede crear estados
    public function an_authenticated_user_can_create_statuses()
    {

        $this->withoutExceptionHandling();

       // 1. Given => Teniendo un usuario autenticado
        $user = factory(User::class)->create();
        $this->actingAs($user);

       // 2. When => Cuando hace un post request a status
        $response = $this->postJson(route('statuses.store'), ['body' => 'Mi primer status']);

        $response->assertJson([
           'data' => ['body' => 'Mi primer status'],

        ]);

       // 3. Then => Entonces veo un nuevo estado en la base de datos
        $this->assertDatabaseHas('statuses', [
            'user_id' => $user->id,
            'body' => 'Mi primer status'
        ]);

    }


    /** @test */
    //Un estatus require un cuerpo
    function a_status_required_a_body()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => '']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }


    /** @test */
    //El cuerpo de un estado requiere de un minimo de caracteres
    function a_status_body_requires_a_minimum_length()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'), ['body' => 'asdf']);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message', 'errors' => ['body']
        ]);

    }

}
