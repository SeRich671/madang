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

            $table->string('address_first_name');
            $table->string('address_last_name');
            $table->string('address_company_name')->nullable();
            $table->string('address_address');
            $table->string('address_city');
            $table->string('address_zipcode');
            $table->string('address_phone');

            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_company_name')->nullable();
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_zipcode');

            $table->string('billing_phone');
            $table->string('billing_email');
            $table->string('billing_nip');

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
