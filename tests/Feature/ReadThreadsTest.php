<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
 
class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
 
        $this->thread = factory('App\Thread')->create();
    }
 
    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }
 
    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get('/threads/' . $this->thread->id);
        $response->assertSee($this->thread->title);
        $response->assertStatus(200);
    }
 
    public function test_a_user_can_see_replies_that_are_associated_with_a_thread()
    {
 
    }
}