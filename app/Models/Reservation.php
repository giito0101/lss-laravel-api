<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Reservation extends Model
{
    use HasUlids;

    protected $fillable = [
        'owner_id',
        'skill_id',
        'date',
        'status',
        'message',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}