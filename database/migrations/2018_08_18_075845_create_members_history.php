<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('members_family_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('relative_name1')->nullable();
            $table->string('relative_name2')->nullable();
            $table->string('relative_name3')->nullable();
            $table->string('relative_name4')->nullable();
            $table->string('relative_name5')->nullable();
            $table->string('relation_relative1')->nullable();
            $table->string('relation_relative2')->nullable();
            $table->string('relation_relative3')->nullable();
            $table->string('relation_relative4')->nullable();
            $table->string('relation_relative5')->nullable();
            $table->string('relative_year1')->nullable();
            $table->string('relative_year2')->nullable();
            $table->string('relative_year3')->nullable();
            $table->string('relative_year4')->nullable();
            $table->string('relative_year5')->nullable();
            $table->string('relative_degree1')->nullable();
            $table->string('relative_degree2')->nullable();
            $table->string('relative_degree3')->nullable();
            $table->string('relative_degree4')->nullable();
            $table->string('relative_degree5')->nullable();
            $table->string('relative_contact1')->nullable();
            $table->string('relative_contact2')->nullable();
            $table->string('relative_contact3')->nullable();
            $table->string('relative_contact4')->nullable();
            $table->string('relative_contact5')->nullable();
            $table->string('reference_name1');
            $table->string('reference_name2');
            $table->string('reference_surname1');
            $table->string('reference_surname2');
            $table->string('reference_address1');
            $table->string('reference_address2');
            $table->string('reference_phone1');
            $table->string('reference_phone2');
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
        Schema::dropIfExists('members_family_history');
    }
}
