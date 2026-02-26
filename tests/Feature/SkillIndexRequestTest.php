<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('スキル一覧APIは category パラメータを必須とする', function () {
    $response = $this->getJson('/api/skills');

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['category']);
});

test('スキル一覧APIは不正な category 値をバリデーションエラーにする', function () {
    $response = $this->getJson('/api/skills?category=INVALID_CATEGORY');

    $response
        ->assertStatus(422)
        ->assertJsonValidationErrors(['category']);
});
