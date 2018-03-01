<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statusable_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('statusable');
            $table->unsignedTinyInteger('status_id')->default(1);
            $table->string('reason')->nullable();
            $table->nullableMorphs('agent');
            $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::dropIfExists('statusable_status');
    }
}
