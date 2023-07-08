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
        Schema::table('mous', function(Blueprint $table) {
            $table->bigInteger('pks_contract_value')->default(0)->change();
            $table->bigInteger('bank_transfer_proceeds')->default(0)->change();
            $table->bigInteger('nominal_difference')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mous', function(Blueprint $table) {
            $table->integer('pks_contract_value')->default(0)->change();
            $table->integer('bank_transfer_proceeds')->default(0)->change();
            $table->integer('nominal_difference')->default(0)->change();
        });
    }
};
