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
        Schema::create('user_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name')->nullable();
            $table->string('collage_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('course_name')->nullable();
            $table->string('description')->nullable();
            $table->integer('page_number')->nullable();
            $table->string('assignment_file_name')->nullable();
            $table->string('instructor_assignment_file_name')->nullable();
            $table->tinyInteger('is_for_dashboard')->nullable();
            $table->integer('is_admin');
            $table->string('status')->default(0);
            $table->integer('assinged_user_id')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_assignments');
    }
};
