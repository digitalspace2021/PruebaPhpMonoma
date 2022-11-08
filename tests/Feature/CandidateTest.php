<?php

namespace Tests\Feature;

use App\Candidate;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    /** @test */
    public function user_can_see_candidates_manager()
    {
        $user=factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $response = $this->actingAs($user)->get('/api/leads');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_see_candidates_agent()
    {
        $user=factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);

        $response = $this->actingAs($user)->get('/api/leads');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_create_candidate_how_manager(){
        $user=factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $agent=factory(User::class)->create([
            'username' => 'agent',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);

        $agent_id=$agent->id;

        $response = $this->actingAs($user)->post('/api/lead',[
            'name' => 'test',
            'source' => 'test',
            'user_id' => 'test',
            'created_by' => $agent->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "meta"=>[
                "success",
            ],
            "data"=>[
                "name",
                "source",
                "user_id",
                "created_by",
            ],
        ]);
    }

    /** @test */
    public function user_cannot_create_candidate_how_agent(){
        $user=factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);

        $agent=factory(User::class)->create([
            'username' => 'agent',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);


        $response = $this->actingAs($user)->post('/api/lead',[
            'name' => 'test',
            'source' => 'test',
            'user_id' => 'test',
            'created_by' => $agent->id,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_one_candidate(){
        $user=factory(User::class)->create([
            'username' => 'user',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $agent=factory(User::class)->create([
            'username' => 'agent',
            'password' => bcrypt('password'),
            'role' => 'agent',
        ]);

        $response = $this->actingAs($user)->post('/api/lead',[
            'name' => 'test',
            'source' => 'test',
            'user_id' => 'test',
            'created_by' => $agent->id,
        ]);

        $candidate=Candidate::first();

        $response = $this->actingAs($user)->get('/api/lead/'.$candidate->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "meta"=>[
                "success",
            ],
            "data"=>[
                "name",
                "source",
                "user_id",
                "created_by",
            ],
        ]);
    }
}
