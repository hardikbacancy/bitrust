<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUserLoanMgmts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_loan_mgmts', function($table) {
            $table->unsignedInteger('request_id')->after('user_id');
            $table->integer('emi_amount')->after('request_id');
            $table->date('emi_paid_date')->after('emi_amount')->nullable();

            $table->foreign('request_id')
                ->references('id')
                ->on('loan_requests')
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
        Schema::table('user_loan_mgmts', function($table) {
            $table->dropColumn('request_id');
            $table->dropColumn('emi_amount');
        });
    }
}
