<?php

use App\Enums\SkillCategory;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('スキルカテゴリは Enum として扱われ、DBには文字列で保存される', function () {
    $skill = Skill::query()->create([
        'owner_id' => 'user-1',
        'title' => 'PHP Mentoring',
        'description' => 'Learn Laravel basics',
        'price' => 5000,
        'category' => SkillCategory::PROGRAMMING->value,
        'area' => 'Tokyo',
    ]);

    $freshSkill = Skill::query()->findOrFail($skill->id);

    expect($freshSkill->category)->toBe(SkillCategory::PROGRAMMING);

    $rawCategory = Skill::query()
        ->withoutGlobalScopes()
        ->toBase()
        ->where('id', $skill->id)
        ->value('category');

    expect($rawCategory)->toBe(SkillCategory::PROGRAMMING->value);
});
