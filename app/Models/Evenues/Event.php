<?php
declare(strict_types=1);

namespace App\Models\Evenues;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'poster',
        'event_date',
        'venue_id'
    ];

    public function venue(): BelongsTo {
        return $this->belongsTo(Venue::class);
    }
}
