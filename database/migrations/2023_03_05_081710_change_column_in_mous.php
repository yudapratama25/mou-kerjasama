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
            $items = ['document_pks', 'document_tor', 'document_rab', 'document_sptjm', 'document_bank_transfer_proceeds'];
            foreach ($items as $item) {
                $table->boolean($item)->default(0)->change();
            }
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
            $items = ['document_pks', 'document_tor', 'document_rab', 'document_sptjm', 'document_bank_transfer_proceeds'];
            foreach ($items as $item) {
                $table->string($item, 20)->change();
            }
        });
    }
};
