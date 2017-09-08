<?php

namespace Tests\Feature;

use App\Lead;
use App\Notifications\LeadAssigned;
use App\Task;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadsTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_task(){
        $user = factory(User::class)->create();
        $lead = factory(Lead::class)->create();

        $response = $this->actingAs($user)->post("leads/{$lead->id}/tasks",["body" => "My first task"] );

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertCount(1, $lead->tasks);
        tap( $lead->tasks->first(), function($task) use($user) {
            $this->assertEquals("My first task", $task->body);
            $this->assertNull($task->date);
            $this->assertEquals($user->id, $task->user_id);
            $this->assertFalse((bool)$task->completed);
        });
    }

    /** @test */
    public function can_complete_a_task(){
        $user = factory(User::class)->create();
        $task = factory(Task::class)->create();
        $this->assertFalse((bool)$task->completed);

        $response = $this->actingAs($user)->put("tasks/{$task->id}",["completed" => true] );

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertTrue((bool)$task->fresh()->completed);
    }
}