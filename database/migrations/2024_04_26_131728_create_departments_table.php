<?php

use App\Enums\Department\StatusEnum;
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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('subdomain');

            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::ON);
            $table->string('footer_type');

            $table->string('email')->nullable();

            $table->text('footer_auth')->nullable();
            $table->text('footer_guest')->nullable();

            $table->boolean('show_change_department')->default(1);
            $table->boolean('show_contact')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
