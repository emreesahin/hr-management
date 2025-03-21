<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role'); // role sütununu kaldır
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->nullable(); // Geri almak için tekrar ekleyebilirsiniz
    });
}

};
