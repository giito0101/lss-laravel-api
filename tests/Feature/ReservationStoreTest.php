<?php

use App\Enums\ReservationStatus;
use App\Enums\SkillCategory;
use App\Models\Reservation;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('予約登録APIは同一ユーザー・同一スキル・同日時の重複予約を拒否する', function () {
    User::factory()->create([
        'id' => 'owner-user',
        'email' => 'owner-user@example.com',
    ]);

    User::factory()->create([
        'id' => 'customer-1',
        'email' => 'customer-1@example.com',
    ]);

    $skill = Skill::query()->create([
        'owner_id' => 'owner-user',
        'title' => 'Laravel Coaching',
        'description' => 'Advanced API design',
        'price' => 9000,
        'category' => SkillCategory::PcSupport->value,
        'area' => 'Tokyo',
    ]);

    $date = now()->addDay()->setSecond(0)->setMicrosecond(0);

    Reservation::query()->create([
        'owner_id' => 'customer-1',
        'skill_id' => $skill->id,
        'date' => $date,
        'status' => ReservationStatus::Pending->value,
        'message' => 'First reservation',
    ]);

    $response = $this
        ->withHeaders(['X-User-Id' => 'customer-1'])
        ->postJson("/api/skills/{$skill->id}/reservations", [
            'date' => $date->toIso8601String(),
            'message' => 'Duplicate reservation',
        ]);

    $response
        ->assertStatus(422)
        ->assertJson(['message' => '同じ日時で既に予約済みです']);
});

test('reservations テーブルの一意制約で重複レコード登録を防ぐ', function () {
    User::factory()->create([
        'id' => 'owner-user',
        'email' => 'owner-user-2@example.com',
    ]);

    User::factory()->create([
        'id' => 'customer-2',
        'email' => 'customer-2@example.com',
    ]);

    $skill = Skill::query()->create([
        'owner_id' => 'owner-user',
        'title' => 'Design Review',
        'description' => 'Portfolio feedback',
        'price' => 7000,
        'category' => SkillCategory::Photo->value,
        'area' => 'Kanagawa',
    ]);

    $date = now()->addDays(2)->setSecond(0)->setMicrosecond(0);

    Reservation::query()->create([
        'owner_id' => 'customer-2',
        'skill_id' => $skill->id,
        'date' => $date,
        'status' => ReservationStatus::Pending->value,
        'message' => null,
    ]);

    expect(function () use ($skill, $date) {
        Reservation::query()->create([
            'owner_id' => 'customer-2',
            'skill_id' => $skill->id,
            'date' => $date,
            'status' => ReservationStatus::Pending->value,
            'message' => null,
        ]);
    })->toThrow(QueryException::class);
});
