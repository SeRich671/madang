<?php

use App\Enums\Order\DeliveryEnum;
use App\Enums\Order\PaymentEnum;
use App\Enums\Order\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('code');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('company_name')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zipcode');
            $table->string('phone');

            $table->text('description')->nullable();

            $table->boolean('finished_by_client')->default(0);

            $table->enum('delivery', DeliveryEnum::getValues());
            $table->enum('payment', PaymentEnum::getValues());

            $table->string('delivery_cost');
            $table->string('payment_cost');
            $table->string('total');
            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::NEW);
            $table->string('admin_comment')->nullable();
            $table->string('client_comment')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
