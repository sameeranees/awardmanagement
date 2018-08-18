<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->unsigned();
            $table->date('award_cermony')->nullable();
            $table->date('application_closing')->nullable();
            $table->date('venue_booking')->nullable();
            $table->date('students_confirmation')->nullable();
        });
        DB::table('year')->insert(
            array(
                'year' => 2018,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('year');
    }
}
