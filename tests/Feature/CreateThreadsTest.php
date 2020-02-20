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
 
        $thread = make('App\Thread');
 
        $response = $this->post('/threads', $thread->toArray());
 
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }
 
    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }
 
    function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }
    
    public function publishThread($overrides = [])
    {
        $this->signIn();
 
        $thread = make('App\Thread', $overrides);
 
        return $this->post('/threads', $thread->toArray());
    }
}

