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
        Schema::table('user_assignments', function (Blueprint $table) {
            $table->string('status')->default(0)->after('is_admin');
            $table->integer('assinged_user_id')->after('status')->nullable();
            $table->string('amount')->after('assinged_user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_assignments', function (Blueprint $table) {
            //
        });
    }
};
