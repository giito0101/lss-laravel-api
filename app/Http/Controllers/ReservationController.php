<?php
namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Skill;

class ReservationController extends Controller
{
    public function store(ReservationStoreRequest $request, Skill $skill)
    {
        // いったん暫定：認証が無いので header から user id を受ける
// Next側から "X-User-Id" を送る運用にしておく（あとで Sanctum/Token に置換）
        $ownerId = $request->header('X-User-Id');
        if (!$ownerId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $reservation = Reservation::create([
            'owner_id' => $ownerId,
            'skill_id' => $skill->id,
            'date' => $request->date('date'),
            'status' => 'PENDING',
            'message' => $request->input('message'),
        ]);

        return response()->json(['data' => $reservation], 201);
    }
}