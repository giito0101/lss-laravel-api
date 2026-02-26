<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillIndexRequest;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index(SkillIndexRequest $request)
    {
        $q = Skill::query();

        $keyword = $request->input('keyword');
        if ($keyword) {
            $q->where(function ($w) use ($keyword) {
                $w->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('area', 'like', "%{$keyword}%");
            });
        }

        $category = $request->input('category');
        if ($category) {
            $q->where('category', $category);
        }

        return $q->latest()->paginate(20);
    }

    public function show(Skill $skill)
    {
        // 必要なら reservations の件数なども付与
        return response()->json([
            'data' => $skill,
        ]);
    }
}
