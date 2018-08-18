<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        //
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('surname');
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
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        //
        Schema::dropIfExists('members');
    }
}
