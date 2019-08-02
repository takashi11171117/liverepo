<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_name02')->default('');
            $table->integer('show_mail_flg')->default(0);
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->integer('gender')->nullable();
            $table->dateTime('birth')->nullable();
            $table->string('image_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_name02',
                'show_mail_flg',
                'url',
                'description',
                'gender',
                'birth',
                'image_path',
            ]);
        });
    }
}
