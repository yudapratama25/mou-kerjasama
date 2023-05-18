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
            $table->date('letter_receipt_date')->nullable(true)->change();
            $table->date('mou_start')->nullable(true)->change();
            $table->date('mou_end')->nullable(true)->change();
            $table->date('pks_start')->nullable(true)->change();
            $table->date('pks_end')->nullable(true)->change();
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
            $table->date('letter_receipt_date')->nullable(false)->change();
            $table->date('mou_start')->nullable(false)->change();
            $table->date('mou_end')->nullable(false)->change();
            $table->date('pks_start')->nullable(false)->change();
            $table->date('pks_end')->nullable(false)->change();
        });
    }
};
