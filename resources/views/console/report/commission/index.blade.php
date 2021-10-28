@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    {{ __('Commission Table') }}
                    <div class="card-header-actions">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" >
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <form class="row" id="report-filter" method="get">
                        <div class="form-group col-sm-4">
                            <label>Report Type</label>
                            <select class="form-control" onchange="$('#report-filter').submit();" name="report_type">
                                <option value="detail" {{ request()->get('report_type') == 'detail' ? 'selected' : null }}>Detail</option>
                                <option value="af" {{ request()->get('report_type') == 'af' ? 'selected' : null }}>Summary by Affiliate</option>
                                <option value="member" {{ request()->get('report_type') == 'member' ? 'selected' : null }}>Summary by Member</option>
{{--                                <option value="month" {{ request()->get('report_type') == 'month' ? 'selected' : null }}>Summary by Month</option>--}}
                            </select>
                        </div>
                    </form>
                    {{$dataTable->table([], true)}}
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
                window.LaravelDataTables["commission-table"].draw();
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

        });
    </script>
@endpush
