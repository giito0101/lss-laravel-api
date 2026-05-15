<?php

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/skills/{skill} returns 200 with skill data', function () {
    $skill = Skill::factory()->create();

    $response = $this->getJson("/api/skills/{$skill->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'owner_id',
                'title',
                'description',
                'price',
                'category',
                'area',
                'image_url',
                'created_at',
                'updated_at',
            ],
        ])
        ->assertJsonPath('data.id', $skill->id)
        ->assertJsonPath('data.title', $skill->title);
});

test('GET /api/skills/{skill} returns 404 when skill not found', function () {
    $response = $this->getJson('/api/skills/non-existent-id');

    $response->assertStatus(404);
});
