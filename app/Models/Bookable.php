<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @method static Bookable findOrFail($id)
 */
class Bookable extends Model
{
    use HasFactory;

    protected $visible = ['id', 'title', 'description', 'price'];

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

    /**
     * Calculate booking price
     * 
     * @param Carbon|string $from
     * @param Carbon|string $to
     * @return array
     */
    public function calcPriceFor($from, $to): array
    {
        if (! ($from instanceof Carbon)) $from = new Carbon($from);
        if (! ($to instanceof Carbon))   $to = new Carbon($to);

        $totalDays = $from->diffInDays($to) + 1;
        $pricePerDay = $this->price;

        return [
            'total' => round($totalDays * $pricePerDay, 2),
            'breakdown' => [
                $pricePerDay => $totalDays
            ]
        ];
    }
}
