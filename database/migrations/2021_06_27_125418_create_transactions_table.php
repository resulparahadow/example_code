<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('previous_id')->nullable();

            $table->unsignedBigInteger('transactionable_id')->index();

            $table->string('transactionable_type');

            // $table->unsignedBigInteger('client_id');

            $table->string('service', 15);
            // $table->string('type');

            $table->unsignedInteger('order');

            $table->string('name');
            $table->string('state');

            $table->json('meta')->nullable();

            $table->json('request')->nullable();

            $table->json('response')->nullable();

            $table->text('exception')->nullable();

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
        Schema::dropIfExists('transactions');
    }
}
