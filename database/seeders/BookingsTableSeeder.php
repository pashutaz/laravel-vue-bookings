<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {
            /** @var Booking $booking */
            $booking = Booking::factory()->make();
            $bookings = collect([$booking]);

            /* Generate random bookings */
            for ($i = 0; $i < random_int(1, 20); $i++) {
                /* At least +1 day from previous booking */
                $from = (clone $booking->to)->addDays(random_int(1, 14));
                $to = (clone $from)->addDays(random_int(0, 14));

                $booking = Booking::make([
                    'from' => $from,
                    'to'   => $to,
                    'cost' => $bookable->price * ($to->diffInDays($from))
                ]);
                $bookings->push($booking);
            }

            $bookable->bookings()->saveMany($bookings);
        });
    }
}
