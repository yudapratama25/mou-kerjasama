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
        Schema::create('mous', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('letter_number', 100);
            $table->date('letter_receipt_date');
            $table->text('regarding_letters');
            $table->string('mou_number', 100);
            $table->date('mou_start');
            $table->date('mou_end');
            $table->string('mou_status', 50);
            $table->string('pks_number', 100);
            $table->date('pks_start');
            $table->date('pks_end');
            $table->string('pks_status', 50);
            $table->text('pks_regarding');
            $table->unsignedInteger('pks_contract_value');
            $table->unsignedInteger('bank_transfer_proceeds');
            $table->integer('nominal_difference');
            $table->string('partner_name');
            $table->string('signature_part_1');
            $table->string('signature_part_2');
            $table->string('document_pks', 20);
            $table->string('document_tor', 20);
            $table->string('document_rab', 20);
            $table->string('document_sptjm', 20);
            $table->string('document_bank_transfer_proceeds', 20);
            $table->string('initial_koor')->nullable();
            $table->string('initial_ppk_pnbp')->nullable();
            $table->string('initial_spi')->nullable();
            $table->string('initial_bagren')->nullable();
            $table->text('description')->nullable();
            $table->string('mou_file', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mous');
    }
};
