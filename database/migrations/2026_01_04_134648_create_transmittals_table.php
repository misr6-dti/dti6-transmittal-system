<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transmittals', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->date('transmittal_date');
            $table->foreignId('sender_user_id')->constrained('users');
            $table->foreignId('sender_office_id')->constrained('offices');
            $table->foreignId('receiver_office_id')->constrained('offices');
            $table->foreignId('receiver_user_id')->nullable()->constrained('users'); // Set when received
            $table->text('remarks')->nullable();
            $table->string('status')->default('Draft'); // Draft, Submitted, Received
            $table->timestamp('received_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmittals');
    }
};
