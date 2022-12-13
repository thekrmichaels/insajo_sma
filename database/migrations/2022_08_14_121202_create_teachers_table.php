<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('class_name')->nullable();
            $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('subject_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
            $table->foreignId('classroom_id')
                    ->nullable()
                    ->constrained()
                    ->nullOnDelete()
                    ->cascadeOnUpdate();
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
        Schema::dropIfExists('teachers');
    }
}
