<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTransmittalItemsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transmittal_items', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->change();
            $table->string('unit')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transmittal_items', function (Blueprint $table) {
            $table->integer('quantity')->nullable(false)->change();
            $table->string('unit')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
        });
    }
}
