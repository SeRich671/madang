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

            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();

            $table->boolean('is_available')->default(1);
            $table->boolean('is_recommended')->default(0);
            $table->boolean('sticker')->default(0);
            $table->boolean('later_delivery')->default(0);
            $table->boolean('bought_by_others')->default(0);

            $table->string('material')->nullable();
            $table->text('img_path')->nullable();

            $table->unsignedInteger('size_set')->nullable();
            $table->unsignedInteger('size_carton')->nullable();

            $table->string('size')->nullable();
            $table->unsignedInteger('count_in_package')->default(1);

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
