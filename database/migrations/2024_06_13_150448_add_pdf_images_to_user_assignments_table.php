<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfImagesToUserAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('user_assignments', 'pdf_images')) {
            Schema::table('user_assignments', function (Blueprint $table) {
                $table->text('pdf_images')->nullable()->after('assignment_file_name');
            });
        }

        if (!Schema::hasColumn('user_assignments', 'instructor_amount')) {
            Schema::table('user_assignments', function (Blueprint $table) {
                $table->string('instructor_amount', 255)->after('is_for_dashboard');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('user_assignments', 'pdf_images')) {
            Schema::table('user_assignments', function (Blueprint $table) {
                $table->dropColumn('pdf_images');
            });
        }

        if (Schema::hasColumn('user_assignments', 'instructor_amount')) {
            Schema::table('user_assignments', function (Blueprint $table) {
                $table->dropColumn('instructor_amount');
            });
        }
    }
}
