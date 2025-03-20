<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['room_id']);
            $table->dropColumn('room_id');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
        });

        Schema::dropIfExists('booking_room');
    }
};