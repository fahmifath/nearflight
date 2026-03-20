<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('airplanes', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('gen_random_uuid()'));
            $table->foreignUuid('airline_id')->constrained('airlines')->cascadeOnDelete();
            $table->string('model', 100);
            $table->string('registration', 20)->unique();
            $table->integer('total_seats');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airplanes');
    }
};
