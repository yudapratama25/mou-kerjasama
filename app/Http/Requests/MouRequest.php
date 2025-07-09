<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MouRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $customize_input = [];

        if ($this->filled('pks_contract_value') && $this->filled('bank_transfer_proceeds') && $this->filled('nominal_difference')) {
            $customize_input['pks_contract_value'] = str_replace('.', '', $this->pks_contract_value);
            $customize_input['bank_transfer_proceeds'] = str_replace('.', '', $this->bank_transfer_proceeds);
            $customize_input['nominal_difference'] = str_replace('.', '', $this->nominal_difference);
        }

        $this->merge($customize_input);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = [
            'unit_id'                         => 'Unit kerja',
            'letter_number'                   => 'Nomor surat',
            'letter_receipt_date'             => 'Tanggal terima surat',
            'regarding_letters'               => 'Perihal surat',
            'mou_number'                      => 'Nomor MOU',
            'mou_status'                      => 'Status MOU',
            'pks_number'                      => 'Nomor PKS',
            'pks_status'                      => 'Status PKS',
            'pks_regarding'                   => 'Nama kegiatan',
            'pks_contract_value'              => 'Nilai kontrak',
            'bank_transfer_proceeds'          => 'Hasil transfer bank',
            'nominal_difference'              => 'Nominal selisih',
            'partner_name'                    => 'Nama mitra',
            'signature_mou_part_1'            => 'Nama Penandatangan MOU Pihak 1',
            'signature_mou_part_2'            => 'Nama Penandatangan MOU Pihak 2',
            'position_mou_part_1'             => 'Jabatan Penandatangan MOU Pihak 1',
            'position_mou_part_2'             => 'Jabatan Penandatangan MOU Pihak 2',
            'signature_pks_part_1'            => 'Nama Penandatangan PKS Pihak 1',
            'signature_pks_part_2'            => 'Nama Penandatangan PKS Pihak 2',
            'position_pks_part_1'             => 'Jabatan Penandatangan PKS Pihak 1',
            'position_pks_part_2'             => 'Jabatan Penandatangan PKS Pihak 2',
            'manager_contact'                 => 'Kontak Pengelola Kegiatan',
            'document_pks'                    => 'Dokumen PKS',
            'document_tor'                    => 'Dokumen TOR',
            'document_rab'                    => 'Dokumen RAB',
            'document_sptjm'                  => 'Dokumen SPTJM',
            'document_mou'                    => 'Dokumen MOU',
            'document_bank_transfer_proceeds' => 'Dokumen Bukti Transfer Bank',
            'cooperation_criteria'            => 'Kriteria Kerja Sama',
            'description'                     => 'Keterangan',
            'files'                           => 'File',
            'files_size'                      => 'Ukuran file',
            'letter_receipt_date_value'       => 'Tanggal terima surat',
            'mou_start_value'                 => 'Tanggal mulai MOU',
            'mou_end_value'                   => 'Tanggal berakhir MOU',
            'pks_start_value'                 => 'Tanggal mulai PKS',
            'pks_end_value'                   => 'Tanggal berakhir PKS',
            'document_start_value'            => 'Tanggal mulai dokumen',
            'document_end_value'              => 'Tanggal berakhir dokumen',
            'hardcopy'                        => 'Hardcopy',
        ];

        return $attributes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'unit_id'                         => 'required|numeric|exists:units,id',
            'letter_number'                   => 'required|string|max:100',
            'letter_receipt_date'             => '',
            'regarding_letters'               => 'required|string',
            'mou_number'                      => 'required|string|max:100',
            'mou_start'                       => '',
            'mou_end'                         => '',
            'mou_status'                      => 'required|in:HIDUP,MATI,DALAM PERPANJANGAN,TIDAK ADA',
            'pks_number'                      => 'required|string|max:100',
            'pks_start'                       => '',
            'pks_end'                         => '',
            'pks_status'                      => 'required|in:HIDUP,MATI,DALAM PERPANJANGAN,TIDAK ADA',
            'pks_regarding'                   => 'required|string',
            'pks_contract_value'              => 'required|numeric',
            'bank_transfer_proceeds'          => 'required|numeric',
            'nominal_difference'              => 'required|numeric',
            'partner_name'                    => 'required|string|max:250',
            'signature_mou_part_1'            => 'required|string|max:250',
            'signature_mou_part_2'            => 'required|string|max:250',
            'position_mou_part_1'             => 'required|string|max:250',
            'position_mou_part_2'             => 'required|string|max:250',
            'signature_pks_part_1'            => 'required|string|max:250',
            'signature_pks_part_2'            => 'required|string|max:250',
            'position_pks_part_1'             => 'required|string|max:250',
            'position_pks_part_2'             => 'required|string|max:250',
            'manager_contact'                 => 'required|string|max:100',
            'document_pks'                    => 'boolean',
            'document_tor'                    => 'boolean',
            'document_rab'                    => 'boolean',
            'document_sptjm'                  => 'boolean',
            'document_mou'                    => 'boolean',
            'document_bank_transfer_proceeds' => 'boolean',
            'cooperation_criteria'            => 'required|string',
            'description'                     => 'max:5000',
            'files'                           => 'array',
            'files_size'                      => 'nullable|array',
            'hardcopy'                        => 'nullable|array',
        ];

        foreach (['letter_receipt_date','mou_start','mou_end','pks_start','pks_end','document_start','document_end'] as $date_value) {
            if ($this->filled($date_value . '_display')) {
                $rules[$date_value . '_value'] = 'required|date';
            }
        }

        if ($this->filled('is_old_data') && $this->is_old_data == '0') {
            $rules['files.*'] = 'file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx,ppt,pptx';
        }

        return $rules;
    }
}
