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
        'year_id',
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
        'document_name',
        'document_number',
        'document_start',
        'document_end',
        'document_status',
        'bank_transfer_proceeds',
        'nominal_difference',
        'partner_name',
        'signature_mou_part_1',
        'signature_mou_part_2',
        'position_mou_part_1',
        'position_mou_part_2',
        'signature_pks_part_1',
        'signature_pks_part_2',
        'position_pks_part_1',
        'position_pks_part_2',
        'manager_contact',
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
        'cooperation_criteria',
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

    public function files()
    {
        return $this->hasMany(MouFile::class, 'mou_id', 'id')->select(['id','mou_id','filename','size']);
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id', 'id')->select(['id','year']);
    }
}
