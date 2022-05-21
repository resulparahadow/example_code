<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Domain\Payments\Enums\PaymentMethod;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique()->index();

            // $table->unsignedBigInteger('user_id')->index();

            $table->unsignedBigInteger('bank_payment_id')->index();

            $table->string('action');

            $table->string('service', 15);
            $table->string('type', 20);

            $table->string('state', 15);

            $table->string('state_bank', 15);

            $table->bigInteger('amount');

            $table->string('destination_number');

            $table->json('meta')->nullable();

            $table->softDeletes();
            $table->timestamp('completed_at')->nullable();

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
        Schema::dropIfExists('payments');
    }
}
