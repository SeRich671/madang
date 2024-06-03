<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->text('description');

            $table->string('price');
            $table->string('discount_price')->nullable();

            $table->boolean('is_available')->default(1);
            $table->boolean('is_recommended')->default(0);
            $table->boolean('sticker')->default(0);
            $table->boolean('later_delivery')->default(0);

            $table->string('material')->nullable();
            $table->text('img_path')->nullable();

            $table->string('size_set')->nullable();
            $table->string('size_carton')->nullable();

            $table->string('size')->nullable();
            $table->string('count_in_package')->default(1);

            $table->string('in_stock')->default(0);

            $table->timestamp('last_available')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
