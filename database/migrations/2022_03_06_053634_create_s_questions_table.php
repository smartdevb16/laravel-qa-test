<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sc_id');
            $table->string('title');
            $table->text('contents');
            $table->unsignedTinyInteger('score');
            $table->string('attached_files');
            $table->string('sanswer_ids');
            $table->string('sreply_ids');
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
        Schema::dropIfExists('s_questions');
    }
}
