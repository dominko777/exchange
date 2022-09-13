<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('send_currency');
            $table->integer('receive_currency');
            $table->float('send_course');
            $table->float('receive_course'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('best_courses');
    }
}
