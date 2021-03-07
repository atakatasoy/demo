<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationSettingsFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_type_id')->after('id');
            $table->boolean('via_sms')->after('password');
            $table->boolean('via_email')->after('via_sms');
            $table->boolean('via_push')->after('via_email');

            $table->foreign('user_type_id')
                ->on('user_types')
                ->references('id')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('via_sms');
            $table->dropColumn('via_email');
            $table->dropColumn('via_push');
        });
    }
}
