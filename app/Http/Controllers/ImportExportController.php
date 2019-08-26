<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportData;
use Excel;
use DB;
use Validator;

class ImportExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('import_data')->where('job_no', '')->orderBy('job_no','asc')->get();
        return view('index',compact('data'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadData(Request $request)
    {
        ini_set('memory_limit', '-1');
        $validatedData = $request->validate([
            'start_date'=>'required',
            'end_date' => 'required|after:start_date'
        ]);

        $data = ImportData::select(
            'job_no as Job Number',
            'doc_recv_date as Recv Date',
            'importer_name as Importer',
            'be_no as BE No',
            'be_date as BE Date',
            'hbl_hawb_no as HAWB No',
            'inv_no as Inv. No',
            'inv_date as Inv. Date',
            'inv_curr as Inv. Curr',
            'inv_curr_rate as Inv. Curr Rate',
            'prod_desc as Product Description',
            'ritc_no as RITC No',
            'material_code as Material Code',
            'prod_qty as Product Qty',
            'prod_unit as Product Unit',
            'prod_unit_price as Unit Price',
            'prod_amount as Product Amount',
            'prod_cif_value as Product CIF Value',
            'total_basic_duty as Total Basic Duty',
            'total_cvd_amt as Total CVD Amt',
            'total_duty as Total Duty',
            'basic_notn as Basic Notn',
            'basic_notn_sno as Basic Notn Sno',
            'basic_duty_rate as Basict Duty Rate',
            'igst_rate as IGST Rate',
            'igst_duty_amt as IGST Duty',
            'cess_duty_amt as Cess Duty',
            'igst_notn as IGST Notn',
            'igst_notn_sno as IGST Notn Sno',
            'igst_ass_value as IGST Ass Value',
            'sws_duty_rate as SWS Duty Rate',
            'sws_duty_amount as SWS Duty Amt',
            'licence_no as Licence No',
            'po_no as PO Number',
            'prev_prod_desc as Prev Prod Desc',
            'prod_max_price as Prod Max Price',
            'prod_diff_price as Prod Diff Price',
            'prev_job_no as Prev Job No',
            'prev_be_no as Prev BE No',
            'prev_be_date as Prev BE Date',
            'prev_hbl_hawb_no as Prev HAWB No',
        )
        ->where('prod_desc','like',$request->input('prod_desc').'%')
        ->where('job_no','like','%'.$request->input('job_no').'%')
        ->whereBetween('doc_recv_date',[$request->input('start_date'),$request->input('end_date')])
        ->get()->toArray();
        
        if(empty($data))
        {
            return view('index',compact('data'));
        }
        else
        {
            $type = $request->input('file_type');
        
            return Excel::create('excel_data', function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->download($type);

            return view('index',compact('data'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importData(Request $request)
    {
        ini_set('memory_limit', '-1');
        $request->validate([
            'import_file' => 'required|mimes:xls,xlsx'
        ]);

        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();
        $file_name = now()->format('YmdHis');
        
        if($data->count()){            
            foreach ($data as $key => $value) {
                /* Delete existing job_number to import_data table */
                DB::table('import_data')->where('job_no', $value->job_number)->delete();
                
                /* Get Material code maximum unit price to import_data table */
                $max_data = DB::table('import_data')->where('material_code', $value->material_code)->orderBy('prod_unit_price', 'desc')->first();                
                
                if(!empty($max_data)){
                    $prev_prod_desc = $max_data->prod_desc;
                    $max_unit_price = $max_data->prod_unit_price;
                    $prev_job_no = $max_data->job_no;
                    $prev_be_no = $max_data->be_no;
                    $prev_be_date = $max_data->be_date;
                    $prev_hbl_hawb_no = $max_data->hbl_hawb_no;
                }
                else{
                    $prev_prod_desc = NULL;
                    $max_unit_price = NULL;
                    $prev_job_no = NULL;
                    $prev_be_no = NULL;
                    $prev_be_date = NULL;
                    $prev_hbl_hawb_no = NULL;
                }

                //dd($max_unit_price);
                
                $arr[] = [
                    'job_no' => $value->job_number,
                    'doc_recv_date' => $value->document_received_date,
                    'importer_name' => $value->importer,
                    'be_no' => $value->be_number,
                    'be_date' => $value->be_date,
                    'hbl_hawb_no' => $value->hbl_hawb_no,
                    'inv_no' => $value->invoice_no,
                    'inv_date' => $value->invoice_date,
                    'inv_curr' => $value->inv_curr,
                    'inv_curr_rate' => $value->inv_curr_rate,
                    'prod_desc' => $value->product_description,
                    'ritc_no' => $value->ritc_no,
                    'material_code' => $value->material_code,
                    'prod_qty' => $value->product_quantity,
                    'prod_unit' => $value->unit,
                    'prod_unit_price' => $value->unit_price,
                    'prod_amount' => $value->product_amount,
                    'prod_cif_value' => $value->cif_value,
                    'total_basic_duty' => $value->total_basic_duty,
                    'total_cvd_amt' => $value->total_cvd_amt,
                    'total_duty' => $value->total_duty,
                    'basic_notn' => $value->basic_notn,
                    'basic_notn_sno' => $value->basic_notn_sno,
                    'basic_duty_rate' => $value->basic_duty_rate,
                    'igst_rate' => $value->igst_duty_rate,
                    'igst_duty_amt' => $value->igst_duty_amount,
                    'cess_duty_amt' => $value->cess_duty_amount,
                    'igst_notn' => $value->igst_notification,
                    'igst_notn_sno' => $value->igst_notification_sno,
                    'igst_ass_value' => $value->igst_ass_value,
                    'sws_duty_rate' => $value->sws_duty_rate,
                    'sws_duty_amount' => $value->sws_duty_amount,
                    'licence_no' => $value->licence_no,
                    'po_no' => $value->po_number,
                    'prev_prod_desc' => $prev_prod_desc,
                    'prod_max_price' => $max_unit_price,
                    'prod_diff_price' => $max_unit_price-$value->unit_price,
                    'prev_job_no' => $prev_job_no,
                    'prev_be_no' => $prev_be_no,
                    'prev_be_date' => $prev_be_date,
                    'prev_hbl_hawb_no' => $prev_hbl_hawb_no,
                    'file_name' => $file_name
                ];
            }
            
            /* Insert data from import_data table */
            if(!empty($arr)){
                DB::table('import_data')->insert($arr);
            }            
        }                
        
        $data = DB::table('import_data')->where('file_name', $file_name)->orderBy('job_no','asc')->get();
        return view('index',compact('data'))->with('success', 'Insert Record successfully.');
    }
}