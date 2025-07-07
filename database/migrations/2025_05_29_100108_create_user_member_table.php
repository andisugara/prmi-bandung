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
        Schema::create('user_member', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the member');
            $table->string('no_member')->unique()->comment('Unique member number');
            $table->string('expired_at')->nullable()->comment('Expiration date of the membership');
            $table->string('joined_at')->nullable()->comment('Date when the member joined');
            $table->string('tanggal_lahir')->nullable()->comment('Date of birth of the member');
            $table->string('alamat')->nullable()->comment('Address of the member');
            $table->string('no_telp')->nullable()->comment('Phone number of the member');
            $table->string('plan')->nullable()->comment('Membership plan of the member');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_member');
    }
};
