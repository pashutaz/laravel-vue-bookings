<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property \Carbon\Carbon $from
 * @property \Carbon\Carbon $to
 */
class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to', 'bookable_id', 'cost'];
    protected $visible = ['id', 'from', 'to', 'bookable'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function findByReviewKey(string $key): ?Booking
    {
        return static::where('review_key', $key)->with('bookable')->get()->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Booking $booking) {
            $booking->review_key = Str::uuid();
        });
    }
}
