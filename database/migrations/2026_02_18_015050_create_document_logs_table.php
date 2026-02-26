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
        Schema::create('document_logs', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            $table->date('log_date');
            
            // Scope
            $table->foreignId('office_id')->constrained('offices');
            
            // Sender info
            $table->foreignId('sender_division_id')->constrained('divisions');
            $table->foreignId('sender_user_id')->constrained('users');
            
            // Receiver info
            $table->foreignId('receiver_division_id')->constrained('divisions');
            $table->foreignId('receiver_user_id')->nullable()->constrained('users'); // Set when received
            
            // Meta
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
        Schema::dropIfExists('document_logs');
    }
};
