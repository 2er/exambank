<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminationsTable extends Migration 
{
	public function up()
	{
		Schema::create('examinations', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title')->index();
            $table->string('file_path');
            $table->integer('subject_id')->unsigned()->index();
            $table->integer('hit_count')->unsigned()->default(0);
            $table->timestamp('last_hit_at');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('examinations');
	}
}
