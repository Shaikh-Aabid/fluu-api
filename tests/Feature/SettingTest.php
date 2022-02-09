<?php

namespace Tests\Feature;

use App\Setting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Site;

class SettingTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->site = factory(Site::class)->create();

        $this->user->assignRole(1);
        $this->user->assignSite($this->site->id);
        $this->headers['siteid'] = $this->site->id;

        factory(Setting::class)->create([
            'site_id' =>  $this->site->id
        ]);

        $this->payload = [
            'banner_1_title' => 'banner_1_title',
            'banner_1_description' => 'banner_1_description',
            'banner_2_title' => 'banner_2_title',
            'banner_2_description' => 'banner_2_description',
            'banner_3_title' => 'banner_3_title',
            'banner_3_description' => 'banner_3_description',
        ];
    }

    /** @test */
    function it_requires_following_details()
    {
        $this->json('post', '/api/settings', [], $this->headers)
            ->assertStatus(422)
            ->assertExactJson([
                "errors"  =>  [
                    "banner_1_title"        =>  ["The banner 1 title field is required."],
                ],
                "message" =>  "The given data was invalid."
            ]);
    }

    /** @test */
    function add_new_login_question()
    {
        $this->disableEH();
        $this->json('post', '/api/settings', $this->payload, $this->headers)
            ->assertStatus(201)
            ->assertJson([
                'data'   => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                ]
            ])
            ->assertJsonStructureExact([
                'data'   => [
                    // 'banner_path_1',
                    'banner_1_title',
                    'banner_1_description',
                    // 'banner_path_2',
                    'banner_2_title',
                    'banner_2_description',
                    // 'banner_path_3',
                    'banner_3_title',
                    'banner_3_description',
                    'site_id',
                    'updated_at',
                    'created_at',
                    'id'
                ]
            ]);
    }

    /** @test */
    function list_of_login_questions()
    {
        $this->disableEH();
        $this->json('GET', '/api/settings', [], $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    0 =>  [
                        // 'banner_path_1',
                        'banner_1_title',
                        'banner_1_description',
                        // 'banner_path_2',
                        'banner_2_title',
                        'banner_2_description',
                        // 'banner_path_3',
                        'banner_3_title',
                        'banner_3_description',
                    ]
                ]
            ]);
        $this->assertCount(1, Setting::all());
    }

    /** @test */
    function show_single_login_question()
    {

        $this->json('get', "/api/settings/1", [], $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'  => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                ]
            ]);
    }

    /** @test */
    function update_single_login_question()
    {
        $payload = [
            'banner_1_title' => 'banner_1_title',
            'banner_1_description' => 'banner_1_description',
            'banner_2_title' => 'banner_2_title',
            'banner_2_description' => 'banner_2_description',
            'banner_3_title' => 'banner_3_title',
            'banner_3_description' => 'banner_3_description',
        ];

        $this->json('patch', '/api/settings/1', $payload, $this->headers)
            ->assertStatus(200)
            ->assertJson([
                'data'    => [
                    'banner_1_title' => 'banner_1_title',
                    'banner_1_description' => 'banner_1_description',
                    'banner_2_title' => 'banner_2_title',
                    'banner_2_description' => 'banner_2_description',
                    'banner_3_title' => 'banner_3_title',
                    'banner_3_description' => 'banner_3_description',
                ]
            ])
            ->assertJsonStructureExact([
                'data'  => [
                    'id',
                    'site_id',
                    'banner_path_1',
                    'banner_1_title',
                    'banner_1_description',
                    'banner_path_2',
                    'banner_2_title',
                    'banner_2_description',
                    'banner_path_3',
                    'banner_3_title',
                    'banner_3_description',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }

    /** @test */
    function delete_login_question()
    {
        $this->json('delete', '/api/settings/1', [], $this->headers)
            ->assertStatus(204);

        $this->assertCount(0, Setting::all());
    }
}
