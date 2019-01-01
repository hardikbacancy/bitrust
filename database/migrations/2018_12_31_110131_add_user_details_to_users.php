<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserDetailsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('gender')->after('password')->nullable();
            $table->integer('email_verified_at')->after('gender')->default(0);
            $table->string('verification_code')->after('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('gender');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('verification_code');
        });
    }
}
