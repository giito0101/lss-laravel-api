<?php
namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Skill;

class ReservationController extends Controller
{
    public function store(ReservationStoreRequest $request, Skill $skill)
    {
        $userId = $request->header('X-User-Id');
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // 自分のスキルを予約禁止
        if ($skill->owner_id === $userId) {
            return response()->json([
                'message' => '自分のスキルは予約できません',
            ], 422);
        }

        $date = $request->date('date');

        // 同日時重複をアプリ側でも先に弾く（DBユニークの前に、メッセージを整えるため）
        $exists = Reservation::query()
            ->where('owner_id', $userId)
            ->where('skill_id', $skill->id)
            ->where('date', $date)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => '同じ日時で既に予約済みです',
            ], 422);
        }

        $reservation = Reservation::create([
            'owner_id' => $userId,
            'skill_id' => $skill->id,
            'date' => $date,
            'status' => 'PENDING',
            'message' => $request->input('message'),
        ]);

        return response()->json(['data' => $reservation], 201);
    }
}