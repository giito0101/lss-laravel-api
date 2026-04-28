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
    Skill::factory()->create(['category' => SkillCategory::English->value]);
    Skill::factory()->create(['category' => SkillCategory::Photo->value]);

    $response = $this->getJson('/api/skills?category=ENGLISH');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.category', SkillCategory::English->value);
});

test('スキル一覧APIは q 指定時にタイトルと説明文で絞り込める', function () {
    Skill::factory()->create([
        'title' => 'Laravel mentoring',
        'description' => 'API review support',
    ]);
    Skill::factory()->create([
        'title' => 'English conversation',
        'description' => 'Business speaking practice',
    ]);

    $response = $this->getJson('/api/skills?q=Laravel');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.title', 'Laravel mentoring');
});

test('スキル一覧APIは area 指定時に該当エリアのみ返す', function () {
    Skill::factory()->create(['area' => 'Tokyo']);
    Skill::factory()->create(['area' => 'Osaka']);

    $response = $this->getJson('/api/skills?area=Tokyo');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.area', 'Tokyo');
});

test('スキル一覧APIは q と area と category の複合条件で絞り込める', function () {
    Skill::factory()->create([
        'title' => 'Laravel API review',
        'category' => SkillCategory::PcSupport->value,
        'area' => 'Tokyo',
    ]);
    Skill::factory()->create([
        'title' => 'Laravel API review',
        'category' => SkillCategory::English->value,
        'area' => 'Tokyo',
    ]);
    Skill::factory()->create([
        'title' => 'Laravel API review',
        'category' => SkillCategory::PcSupport->value,
        'area' => 'Osaka',
    ]);

    $response = $this->getJson('/api/skills?q=Laravel&category=PC_SUPPORT&area=Tokyo');

    $response
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.category', SkillCategory::PcSupport->value)
        ->assertJsonPath('data.0.area', 'Tokyo');
});
