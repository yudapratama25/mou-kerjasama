<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mous', function (Blueprint $table) {
            $table->after('document_bank_transfer_proceeds', function($table) {
               $table->boolean('document_sk_uls')->default(0);
               $table->boolean('document_sk_pengelola_kerjasama')->default(0);
               $table->boolean('document_ia')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mous', function (Blueprint $table) {
            $table->dropColumn('document_sk_uls');
            $table->dropColumn('document_sk_pengelola_kerjasama');
            $table->dropColumn('document_ia');
        });
    }
};
