<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->string('message_id', 255)->nullable();
            $table->integer('contact_id');
            $table->integer('campaign_id');
            $table->datetime('sent_at')->nullable();
            $table->datetime('opened_at')->nullable();
            $table->datetime('bounced_at')->nullable();
            $table->datetime('complaint_at')->nullable();
            $table->datetime('unsubscribed_at')->nullable();
            $table->datetime('failed_at')->nullable();
            $table->text('failed_reason')->nullable();
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
