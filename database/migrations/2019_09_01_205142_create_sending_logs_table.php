<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSendingLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contact_id');
            $table->integer('campaign_id');
            $table->datetime('sent_at')->nullable();
            $table->datetime('opened_at')->nullable();
            $table->datetime('bounced_at')->nullable();
            $table->datetime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sending_logs');
    }
}
