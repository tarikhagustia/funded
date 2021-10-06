@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    {{ __('Last Withdrawal and Deposit') }}
                    <div class="card-header-actions">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" >
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    {{$dataTable->table()}}
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-3 ml-auto">
                            <select name="type" id="select-type" class="form-control">
                                <option value="Withdrawal" selected>Withdrawal</option>
                                <option value="New Account">New Account</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    {{ $dataTable->scripts() }}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script type="text/javascript">
        $(function() {

            var start = moment();
            var end = moment();

            function cb(start, end) {

                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                window.LaravelDataTables["withdrawal-table"].draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $("#select-type").change(function(){
                window.LaravelDataTables["withdrawal-table"].draw();
            })

        });
    </script>
@endpush
