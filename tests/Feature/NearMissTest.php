<?php

namespace Tests\Feature;

use App\NearMiss;
use App\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NearMissTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(NearMiss::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'number_reported' => 1,
            'location_id' => 1,
            'category_id' => 1,
            'activity_id' => 1,
            'basic_cause_id' => 1,
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/near_misses', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "number_reported"        =>  ["The number reported field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_near_miss()
    {
        $this->disableEH();
        $this->json('post', '/api/near_misses', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'number_reported' => 1,
                    'location_id' => 1,
                    'category_id' => 1,
                    'activity_id' => 1,
                    'basic_cause_id' => 1,
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    'number_reported',
                    'location_id',
                    'category_id',
                    'activity_id',
                    'basic_cause_id',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_near_misses()
    {
        $this->disableEH();
        $this->json('GET', '/api/near_misses', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        'number_reported',
                        'location_id',
                        'category_id',
                        'activity_id',
                        'basic_cause_id',
                    ]
                ]
            ]);
        $this->assertCount(1, NearMiss::all());
    }

    /** @test */
    function show_single_near_miss()
    {

        $this->json('get', "/api/near_misses/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'number_reported' => 1,
                    'location_id' => 1,
                    'category_id' => 1,
                    'activity_id' => 1,
                    'basic_cause_id' => 1,
                ]
            ]);
    }

    /** @test */
    function update_single_near_miss()
    {
        $payload = [
            'number_reported' => 2,
            'location_id' => 2,
            'category_id' => 2,
            'activity_id' => 2,
            'basic_cause_id' => 2,
        ];

        $this->json('patch', '/api/near_misses/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'number_reported' => 2,
                    'location_id' => 2,
                    'category_id' => 2,
                    'activity_id' => 2,
                    'basic_cause_id' => 2,
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'number_reported',
                    'location_id',
                    'category_id',
                    'activity_id',
                    'basic_cause_id',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_near_miss()
    {
        $this->json('delete', '/api/near_misses/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, NearMiss::all());
    }
}