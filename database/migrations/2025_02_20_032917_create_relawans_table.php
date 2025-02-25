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
        Schema::create('relawans', function (Blueprint $table) {
            $table->id();
            $table->string('identity');
            $table->string('email');
            $table->string('fullname');
            $table->string('wa_number');
            $table->string('address');
            $table->integer('frequency');
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
        Schema::dropIfExists('relawans');
    }
};
