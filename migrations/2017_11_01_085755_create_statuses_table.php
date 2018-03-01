<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->json('title');
            $table->json('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->timestamps();
        });

        $status = new \Roshangara\Statusable\Models\Status();
        $status->setTranslation('title', 'fa', 'جدید');
        $status->setTranslation('title', 'en', 'new');
        $status->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
