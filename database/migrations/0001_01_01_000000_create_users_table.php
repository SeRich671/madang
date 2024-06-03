<?php

use App\Enums\User\RoleEnum;
use App\Enums\User\StatusEnum;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('login')->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('nip')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_zipcode')->nullable();
            $table->string('company_fax')->nullable();

            $table->string('password');

            $table->boolean('marketing')->default(0);
            $table->boolean('conditions')->default(0);
            $table->boolean('uncertain')->default(0);

            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::NOT_ACCEPTED);
            $table->enum('role', RoleEnum::getValues())->default(RoleEnum::USER);

            $table->rememberToken();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('logged_in_new_system')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
