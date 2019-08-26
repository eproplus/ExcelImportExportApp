<html lang="en">
<head>
    <title>Visual Impex Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<style>    
    .container{
        margin-top: 2%;
    }

    .body {
        background-color: #ccd9f9;
    }
    
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }
    #customers tr:nth-child(even){background-color: #f2f2f2;}
    #customers tr:hover {background-color: #ddd;}
    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #283361;
        color: white;
    }
</style>
<body>
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif
    <div class="card body">
        <div class="card-body">
            <h5 class="card-title row justify-content-center">
                <strong>Visual Impex Data Import Export to Excel , CSV Example</strong>
            </h5>
            <!-- <br/>
            <a href="{{ url('downloadData/xlsx') }}"><button class="btn btn-dark">Download Excel xlsx</button></a>
            <a href="{{ url('downloadData/xls') }}"><button class="btn btn-success">Download Excel xls</button></a>
            <a href="{{ url('downloadData/csv') }}"><button class="btn btn-info">Download CSV</button></a> -->

            <form style="border: 2px solid #a1a1a1;margin-top: 15px;padding: 5px;text-align: center;" action="{{ url('importData') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="import_file" />
                <button class="btn btn-primary" onclick="return confirm('Are you sure existing job number replace it?')">Import File</button>
            </form>
            <form action="{{ url('downloadData') }}" method="get">
                <div class="row align-items-center">
                    <div class="form-group col-md-2">
                        <strong>Start Date <span class="text-danger"></span></strong>
                        <div class="controls">
                            <input type="date" name="start_date" id="start_date" class="form-control datepicker-autoclose" placeholder="Please select start date"> <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <strong>End Date <span class="text-danger"></span></strong>
                        <div class="controls">
                            <input type="date" name="end_date" id="end_date" class="form-control datepicker-autoclose" placeholder="Please select end date"> <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <strong>Product Description <span class="text-danger"></span></strong>
                        <div class="controls">
                            <input type="text" name="prod_description" id="prod_description" class="form-control datepicker-autoclose" placeholder="Please enter the product description"> <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <strong>Job Number<span class="text-danger"></span></strong>
                        <div class="controls">
                            <input type="text" name="job_no" id="job_no" class="form-control datepicker-autoclose"> <div class="help-block"></div>
                        </div>
                    </div>
                    <div class="form-group col-md-1">
                        <strong>File<span class="text-danger"></span></strong>
                        <div class="controls">
                            <select name="file_type" class="form-control">
                                <option>xlsx</option>
                                <option>csv</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-left col-md-1" style="margin-left: 15px;">
                        <!-- <button id="btnFiterSubmitSearch" class="btn btn-primary">Export to Excel</button> -->
                        <a href="{{ url('downloadData/xlsx') }}" ><button class="btn btn-primary">Export</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br/>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive" style="width: 100%; height: 600px; overflow-y: scroll;">
            <table id="customers" >
                <tr>
                    <th>Job No</th>
                    <th>Doc. Date</th>
                    <th>Importer</th>
                    <th>BE No</th>
                    <th>BE Date</th>
                    <th>HBL/BL No</th>
                    <th>Inv. No</th>
                    <th>Inv. Date</th>
                    <th>Inv. Curr</th>
                    <th>Curr Rate</th>
                    <th>Prod Desc</th>
                    <th>RITC No</th>
                    <th>Prod Qty</th>
                    <th>Prod Unit</th>
                    <th>Unit Price</th>
                    <th>Prod Amount</th>
                    <th>CIF Value</th>
                    <th>Total BD</th>
                    <th>Total CVD Amt</th>
                    <th>Total Duty</th>
                    <th>Basic Notn</th>
                    <th>Basic Notn Sno</th>
                    <th>BD Rate</th>
                    <th>IGST Rate</th>
                    <th>IGST Duty Rate</th>
                    <th>Cess Duty Amt</th>
                    <th>IGST Notn</th>
                    <th>IGST Notn Sno</th>
                    <th>IGST Ass Value</th>
                    <th>SWS Duty Rate</th>
                    <th>SWS Duty Amt</th>
                    <th>License No</th>
                    <th>PO No</th>
                    <th>Max Price</th>
                    <th>Prev Job No</th>
                    <th>Prev BE No</th>
                    <th>Prev BE date</th>
                    <th>prev HAWB No</th>
                </tr>
                @foreach($data as $row)
                <tr>
                    <td>{{ $row->job_no }}</td>
                    <td>{{ $row->doc_recv_date }}</td>
                    <td>{{ $row->importer_name }}</td>
                    <td>{{ $row->be_no }}</td>
                    <td>{{ $row->be_date }}</td>
                    <td>{{ $row->hbl_hawb_no }}</td>
                    <td>{{ $row->inv_no }}</td>
                    <td>{{ $row->inv_date }}</td>
                    <td>{{ $row->inv_curr }}</td>
                    <td>{{ $row->inv_curr_rate }}</td>
                    <td>{{ $row->prod_desc }}</td>
                    <td>{{ $row->ritc_no }}</td>
                    <td>{{ $row->material_code }}</td>
                    <td>{{ $row->prod_qty }}</td>
                    <td>{{ $row->prod_unit }}</td>
                    <td>{{ $row->prod_unit_price }}</td>
                    <td>{{ $row->prod_amount }}</td>
                    <td>{{ $row->prod_cif_value }}</td>
                    <td>{{ $row->total_basic_duty }}</td>
                    <td>{{ $row->total_cvd_amt }}</td>
                    <td>{{ $row->total_duty }}</td>
                    <td>{{ $row->basic_notn }}</td>
                    <td>{{ $row->basic_duty_rate }}</td>
                    <td>{{ $row->igst_rate }}</td>
                    <td>{{ $row->igst_duty_amt }}</td>
                    <td>{{ $row->cess_duty_amt }}</td>
                    <td>{{ $row->igst_notn }}</td>
                    <td>{{ $row->igst_notn_sno }}</td>
                    <td>{{ $row->igst_ass_value }}</td>
                    <td>{{ $row->sws_duty_rate }}</td>
                    <td>{{ $row->sws_duty_amount }}</td>
                    <td>{{ $row->licence_no }}</td>
                    <td>{{ $row->po_no }}</td>
                    <td>{{ $row->prod_max_price }}</td>
                    <td>{{ $row->prod_diff_price }}</td>
                    <td>{{ $row->prev_job_no }}</td>
                    <td>{{ $row->prev_be_no }}</td>
                    <td>{{ $row->prev_be_date }}</td>
                    <td>{{ $row->prev_hbl_hawb_no }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>