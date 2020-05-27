<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{

    use RefreshDatabase;
  /** @test */

  //un estado pertenece a un usuario
  function a_status_belongs_to_a_users()
  {
    $status = factory(Status::class)->create();


    $this->assertInstanceOf(User::class, $status->user);
  }

}
