<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('airline_id')->constrained('airlines')->cascadeOnDelete();
            $table->foreignUuid('airplane_id')->constrained('airplanes')->cascadeOnDelete();
            $table->foreignUuid('origin_airport_id')->constrained('airports')->restrictOnDelete();
            $table->foreignUuid('destination_airport_id')->constrained('airports')->restrictOnDelete();
            $table->string('flight_number', 10);
            $table->timestamp('departure_at');
            $table->timestamp('arrival_at');
            $table->enum('status', [
                'scheduled',
                'boarding',
                'departed',
                'arrived',
                'cancelled',
                'delayed',
            ])->default('scheduled');
            $table->timestamps();

            $table->index(['departure_at', 'status']);
            $table->index(['origin_airport_id', 'destination_airport_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
