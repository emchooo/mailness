<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('email');
            $table->integer('list_id');
            $table->boolean('subscribed')->default(1);
            $table->datetime('unsubscribed_at')->nullable();
            $table->datetime('confirmed_at')->nullable();
            $table->string('unsubscribe_type')->nullable();
            $table->timestamps();

            $table->index(['list_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
