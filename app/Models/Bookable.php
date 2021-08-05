<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Bookable findOrFail($id)
 */
class Bookable extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'description'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function availableFor($from, $to): bool
    {
        return 0 === $this->bookings()
            ->where('to', '>=', $from)
            ->where('from', '<=', $to)
            ->count();
    }
}
