<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\SkillCategory;

class Skill extends Model
{
    use HasUlids;
    use HasFactory;
    protected $casts = [
        'category' => SkillCategory::class,
    ];

    protected $fillable = [
        'owner_id',
        'title',
        'description',
        'price',
        'category',
        'area',
        'image_url',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}