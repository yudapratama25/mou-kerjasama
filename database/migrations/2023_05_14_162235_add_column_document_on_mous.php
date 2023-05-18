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
            $table->after('nominal_difference', function($table) {
                $table->text('document_name')->nullable();
                $table->string('document_number', 100)->nullable();
                $table->date('document_start')->nullable();
                $table->date('document_end')->nullable();
                $table->string('document_status')->nullable();
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
            $table->dropColumn(['document_name', 'document_number', 'document_start', 'document_end', 'document_status']);
        });
    }
};
