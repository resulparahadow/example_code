<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Domain\Payments\Enums\PaymentMethod;

class CreateBankPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index();

            $table->string('order_id')->nullable();

            // $table->unsignedBigInteger('paymentable_id')->index();

            // $table->string('paymentable_type');

            $table->json('meta')->nullable();

            $table->string('state', 15);

            $table->string('type', 15);

            $table->bigInteger('amount');

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
        Schema::dropIfExists('bank_payments');
    }
}
