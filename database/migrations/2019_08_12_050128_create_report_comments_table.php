<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text('body');
            $table->integer('user_id')->unsigned();

            $table->integer('report_id')->unsigned();
            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_comments');
    }
}
