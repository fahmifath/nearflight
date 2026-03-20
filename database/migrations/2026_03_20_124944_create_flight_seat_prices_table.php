<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flight_seat_prices', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('flight_id')->constrained('flights')->cascadeOnDelete();
            $table->enum('class_type', ['economy', 'business', 'first_class']);
            $table->decimal('base_price', 12, 2);
            $table->decimal('extra_legroom_fee', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['flight_id', 'class_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flight_seat_prices');
    }
};
