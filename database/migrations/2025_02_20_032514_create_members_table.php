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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('identity')->unique();
            $table->string('email')->unique();
            $table->string('fullname');
            $table->string('wa_number')->unique();
            $table->string('address');
            $table->integer('point_total');
            $table->boolean('is_checked')->default(false);
            $table->timestamp('date_checked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
