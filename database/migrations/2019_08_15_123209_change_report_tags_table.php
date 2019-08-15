<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeReportTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_tags', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->unique(['name', 'taxonomy']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_tags', function (Blueprint $table) {
            $table->unique(['name']);
            $table->dropUnique(['name', 'taxonomy']);
        });
    }
}
