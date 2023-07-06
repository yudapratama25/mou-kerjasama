<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $columns = [
        'position_mou_part_1',
        'position_mou_part_2',
        'signature_pks_part_1',
        'signature_pks_part_2',
        'position_pks_part_1',
        'position_pks_part_2',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mous', function (Blueprint $table) {
            $table->after('signature_mou_part_2', function($table) {
                foreach ($this->columns as $column) {
                    $table->string($column);
                }
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
            $table->dropColumn($this->columns);
        });
    }
};
