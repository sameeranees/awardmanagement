<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('degrees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('degree_name');
        });
        Schema::create('majors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('majors_name');
            $table->integer('degree_id')->unsigned();
            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('form_no');
            $table->string('surname')->unique();
            $table->string('fathers_name');
            $table->string('gender');
            $table->string('phone');
            $table->string('email');
            $table->string('dam_no');
            $table->string('address');
            $table->string('name_of_institute');
            $table->integer('marks_obtained');
            $table->integer('total_marks');
            $table->float('gpa');
            $table->string('distinctions');
            $table->integer('passing_year');
            $table->string('previous_qualifications');
            $table->integer('A*s');
            $table->integer('As');
            $table->integer('Bs');
            $table->integer('Cs');
            $table->integer('Ds');
            $table->integer('Fs');
            $table->integer('degree_id')->unsigned();
            $table->integer('majors_id')->unsigned();
            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('majors_id')->references('id')->on('majors')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
        Schema::create('members_family_history', function (Blueprint $table) {
            $table->increments('id');
            $table->string('relative_name1');
            $table->string('relative_name2');
            $table->string('relative_name3');
            $table->string('relative_name4');
            $table->string('relative_name5');
            $table->string('relation_relative1');
            $table->string('relation_relative2');
            $table->string('relation_relative3');
            $table->string('relation_relative4');
            $table->string('relation_relative5');
            $table->string('relative_year1');
            $table->string('relative_year2');
            $table->string('relative_year3');
            $table->string('relative_year4');
            $table->string('relative_year5');
            $table->string('relative_degree1');
            $table->string('relative_degree2');
            $table->string('relative_degree3');
            $table->string('relative_degree4');
            $table->string('relative_degree5');
            $table->string('relative_contact1');
            $table->string('relative_contact2');
            $table->string('relative_contact3');
            $table->string('relative_contact4');
            $table->string('relative_contact5');
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('degrees');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('history');
    }
}
