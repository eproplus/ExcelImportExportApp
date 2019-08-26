<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportData extends Model
{
    protected $fillable = [
        'job_no',
        'doc_recv_date',
        'importer_name',
        'be_no',
        'be_date',
        'hbl_hawb_no',
        'inv_no',
        'inv_date',
        'inv_curr',
        'inv_curr_rate',
        'prod_desc',
        'ritc_no',
        'material_code',
        'prod_qty',
        'prod_unit',
        'prod_unti_price',
        'prod_amount',
        'prod_cif_value',
        'total_basic_duty',
        'total_cvd_amt',
        'total_duty',
        'basic_notn',
        'basic_notn_sno',
        'basic_duty_rate',
        'igst_rate',
        'igst_duty_amt',
        'cess_duty_amt',
        'igst_notn',
        'igst_notn_sno',
        'igst_ass_value',
        'sws_duty_rate',
        'sws_duty_amount',
        'licence_no',
        'po_no',
        'prod_max_price',
        'prod_diff_price',
        'create_at',
        'updated_at'
    ];
}
