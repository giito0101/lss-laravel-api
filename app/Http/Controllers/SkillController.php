<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillIndexRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkillController extends Controller
{
    public function index(SkillIndexRequest $request): AnonymousResourceCollection
    {
        $skills = Skill::query();

        $keyword = $request->string('q')->toString();
        if ($keyword !== '') {
            $skills->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('area', 'like', "%{$keyword}%");
            });
        }

        $category = $request->string('category')->toString();
        if ($category !== '') {
            $skills->where('category', $category);
        }

        $area = $request->string('area')->toString();
        if ($area !== '') {
            $skills->where('area', 'like', "%{$area}%");
        }

        return SkillResource::collection($skills->latest()->paginate(20));
    }

    public function show(Skill $skill): SkillResource
    {
        return new SkillResource($skill);
    }
}
