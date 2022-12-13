<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('student_id')
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->uuid('uuid')->nullable();
            $table->binary('homework');
            $table->dateTime('sent_at', $precision = 0)->useCurrent();
            $table->decimal('score', $precision = 2, $scale = 1)->nullable();
            $table->dateTime('scored_at', $precision = 0)->nullable();
            $table->dateTime('modified_at', $precision = 0)->nullable();
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
        Schema::dropIfExists('schoolworks');
    }
}
