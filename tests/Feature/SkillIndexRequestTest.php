<?php

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('スキル一覧APIは category パラメータ未指定でも取得できる', function () {
    $response = $this->getJson('/api/skills');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'current_page',
            'data',
            'last_page',
            'total',
        ]);
});

test('スキル一覧APIは不正な category 値をバリデーションエラーにする', function () {
    $response = $this->getJson('/api/skills?category=INVALID_CATEGORY');

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['category']);
});

test('スキル一覧APIは category 指定時に該当カテゴリのみ返す', function () {
    Skill::factory()->create(['category' => SkillCategory::PROGRAMMING->value]);
    Skill::factory()->create(['category' => SkillCategory::DESIGN->value]);

    $response = $this->getJson('/api/skills?category=PROGRAMMING');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.category', SkillCategory::PROGRAMMING->value);
});
