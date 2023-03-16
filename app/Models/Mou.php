<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mou extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = "mous";

    protected $fillable = [
        'unit_id',
        'user_id',
        'letter_number',
        'letter_receipt_date',
        'regarding_letters',
        'mou_number',
        'mou_start',
        'mou_end',
        'mou_status',
        'pks_number',
        'pks_start',
        'pks_end',
        'pks_status',
        'pks_regarding',
        'pks_contract_value',
        'bank_transfer_proceeds',
        'nominal_difference',
        'partner_name',
        'signature_part_1',
        'signature_part_2',
        'document_pks',
        'document_tor',
        'document_rab',
        'document_sptjm',
        'document_mou',
        'document_bank_transfer_proceeds',
        'initial_koor',
        'initial_ppk_pnbp',
        'initial_spi',
        'initial_bagren',
        'description',
        'mou_file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
}
