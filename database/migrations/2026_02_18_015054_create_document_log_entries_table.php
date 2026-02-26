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
        Schema::create('document_log_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_log_id')->constrained('document_logs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('action'); // Created, Submitted, Received, Updated
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_log_entries');
    }
};
