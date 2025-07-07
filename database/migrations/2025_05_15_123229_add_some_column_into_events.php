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
        // tambah harga member,harga non member tapi punya akun, harga normal
        Schema::table('events', function (Blueprint $table) {
            $table->double('member_price')->after('status')->default(0)->comment('harga member');
            $table->double('non_member_price')->after('member_price')->default(0)->comment('harga non member tapi punya akun');
            $table->double('normal_price')->after('non_member_price')->default(0)->comment('harga normal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('member_price');
            $table->dropColumn('non_member_price');
            $table->dropColumn('normal_price');
        });
    }
};
