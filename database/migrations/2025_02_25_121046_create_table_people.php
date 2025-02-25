<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by');
            $table->string('first_name', 255)->collation('utf8mb4_unicode_ci');
            $table->string('last_name', 255)->collation('utf8mb4_unicode_ci');
            $table->string('birth_name', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->string('middle_names', 255)->collation('utf8mb4_unicode_ci')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();

            $table->primary('id');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
