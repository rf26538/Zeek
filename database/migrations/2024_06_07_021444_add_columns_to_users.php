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
        if (!Schema::hasColumn('users', 'is_for_dashboard')) {
            Schema::table('users', function (Blueprint $table) {
                $table->integer('is_for_dashboard')->default(0)->after('provider_user_id');
            });
        }

        if (!Schema::hasColumn('users', 'instructor_amount')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('instructor_amount', 255)->after('is_for_dashboard');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'is_for_dashboard')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_for_dashboard');
            });
        }

        if (Schema::hasColumn('users', 'instructor_amount')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('instructor_amount');
            });
        }
    }
};
