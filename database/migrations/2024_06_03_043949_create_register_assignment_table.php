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
        Schema::create('register_assignment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('collage_name');
            $table->string('department_name');
            $table->string('course_name');
            $table->string('description');
            $table->integer('page_number');
            $table->string('assignment_files_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_assignment');
    }
};
