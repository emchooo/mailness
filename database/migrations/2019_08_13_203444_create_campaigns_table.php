<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('status');
            $table->string('subject');
            $table->string('sending_name');
            $table->string('sending_email');
            $table->string('preview_text')->nullable();
            $table->longText('html');
            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);
            $table->integer('sent_to_number')->default(0);
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
        Schema::dropIfExists('campaigns');
    }
}
