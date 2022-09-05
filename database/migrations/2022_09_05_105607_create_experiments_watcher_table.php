<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExperimentsWatcherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiments_watcher', function (Blueprint $table) {
            $table->id();

            $table->string('experiment_id');
            $table->string('experiment_hash');
            $table->string('experiment_name');
            $table->bigInteger('experiment_created')->nullable();
            $table->bigInteger('experiment_updated')->nullable();
            $table->enum('experiment_type', ['user', 'guild', 'unknown'])->default('unknown');

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
        Schema::dropIfExists('experiments_watcher');
    }
}
