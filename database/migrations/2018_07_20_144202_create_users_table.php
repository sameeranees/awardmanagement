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
            $table->string('surname')->unique();
            $table->string('fathers_name');
            $table->string('gender');
            $table->string('phone');
            $table->string('email');
            $table->string('dam_no');
            $table->string('address');
            $table->string('name_of_institute');
            $table->integer('marks_obtained')->nullable();
            $table->integer('total_marks')->nullable();
            $table->float('gpa')->nullable();
            $table->string('distinctions')->nullable();
            $table->integer('passing_year')->nullable();
            $table->string('previous_qualifications')->nullable();
            $table->integer('A*s')->nullable();
            $table->integer('As')->nullable();
            $table->integer('Bs')->nullable();
            $table->integer('Cs')->nullable();
            $table->integer('Ds')->nullable();
            $table->integer('Fs')->nullable();
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('majors');
        Schema::dropIfExists('degrees');
        Schema::dropIfExists('members_family_history');
    }
}
