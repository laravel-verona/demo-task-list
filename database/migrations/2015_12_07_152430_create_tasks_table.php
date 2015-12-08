<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('task');
            $table->boolean('done')->default(false);
            $table->integer('created_by')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('tasks', function($table) {
            $table->foreign('created_by')
                        ->references('id')->on('users')
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
        Schema::dropIfExists('tasks');
    }
}
