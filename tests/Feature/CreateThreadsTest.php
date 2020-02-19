<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    function test_guest_can_not_create_threads()
    {
        $this->get('/threads/create')->assertRedirect('/login');
 
        $this->post('/threads')->assertRedirect('login');
    }
 
    function test_a_logged_in_user_can_create_new_threads()
    {
        $this->withoutExceptionHandling()->signIn();
 
        $thread = create('App\Thread');
 
        $this->post('/threads', $thread->toArray());
 
        $this->get($thread->path())->assertSee($thread->title);
    }
}

