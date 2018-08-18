<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberidFamilyHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('members_family_history', function($table) {
            $table->integer('members_id')->unsigned();
            $table->foreign('members_id')->references('id')->on('members')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('members', function($table) {
            $table->integer('year');
        });
        Schema::table('members', function($table) {
            $table->boolean('dysf_scholar')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('members_family_history', function($table) {
            $table->foreign('members_id')->references('id')->on('members');
            $table->dropColumn('members_id');
        });
        Schema::table('members', function($table) {
            $table->dropColumn('year');
        });
        Schema::table('members', function($table) {
            $table->dropColumn('dysf_scholar');
        });
        
    }
}
