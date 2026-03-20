<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('cart_id')->constrained('carts')->cascadeOnDelete();
            $table->foreignUuid('flight_id')->constrained('flights')->cascadeOnDelete();
            $table->foreignUuid('seat_config_id')->constrained('seat_configurations')->cascadeOnDelete();
            $table->foreignUuid('passenger_id')->nullable()->constrained('passengers')->nullOnDelete();
            $table->enum('class_type', ['economy', 'business', 'first_class']);
            $table->decimal('price_snapshot', 12, 2);
            $table->timestamps();

            $table->index(['cart_id', 'flight_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
