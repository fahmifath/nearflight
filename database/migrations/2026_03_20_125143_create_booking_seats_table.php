<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_seats', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignUuid('flight_id')->constrained('flights')->restrictOnDelete();
            $table->foreignUuid('seat_config_id')->constrained('seat_configurations')->restrictOnDelete();
            $table->foreignUuid('passenger_id')->constrained('passengers')->restrictOnDelete();
            $table->enum('class_type', ['economy', 'business', 'first_class']);
            $table->decimal('price', 12, 2);
            $table->string('ticket_number', 20)->unique();
            $table->string('eticket_path')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'flight_id']);
            $table->unique(['flight_id', 'seat_config_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_seats');
    }
};
