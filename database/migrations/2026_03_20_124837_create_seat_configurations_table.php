<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seat_configurations', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('airplane_id')->constrained('airplanes')->cascadeOnDelete();
            $table->string('seat_number', 10);
            $table->enum('class_type', ['economy', 'business', 'first_class']);
            $table->boolean('is_window')->default(false);
            $table->boolean('is_aisle')->default(false);
            $table->boolean('has_extra_legroom')->default(false);
            $table->timestamps();

            $table->unique(['airplane_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seat_configurations');
    }
};
