@push('stylesheet')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        (function ($, DataTable) {
            DataTable.ext.buttons.daterange = {
                className: 'buttons-daterange',

                text: function (dt) {
                    @if (is_array($dates) && count($dates) == 2 && ($dates[0] != null && $dates[1] != null))
                        return  '<input id="daterange-input" name="dates" type="text" value="{{ $dates[0] }} - {{ $dates[1] }}" style="position: absolute; visibility: hidden;"><i class="fas fa-calendar"></i> <span id="daterange-label">{{ $dates[0] }} - {{ $dates[1] }}</span>';
                    @else
                        return  '<input id="daterange-input" name="dates" type="text" value="" style="position: absolute; visibility: hidden;"><i class="fas fa-calendar"></i> <span id="daterange-label">Date Filter</span>';
                    @endif
                },

                action: function (e, dt, button, config) {
                    if (typeof $('#daterange-input').attr('data-picker') == 'undefined') {
                        $('#daterange-input').daterangepicker({
                            opens: 'center',
                            @if (is_array($dates) && count($dates) == 2 && ($dates[0] != null && $dates[1] != null))
                                startDate: '{{ $dates[0] }}',
                                endDate: '{{ $dates[1] }}',
                            @endif
                            locale: {
                                format: 'YYYY-MM-DD',
                            },
                        }).on('apply.daterangepicker', function (e, picker) {
                            let startDate = picker.startDate.format('YYYY-MM-DD');
                            let endDate = picker.endDate.format('YYYY-MM-DD');

                            $('#daterange-label').text(`${startDate} - ${endDate}`);

                            dt.search('');
                            dt.columns().search();
                            dt.ajax.url(`?dates[]=${startDate}&dates[]=${endDate}`);
                            dt.draw();
                        });

                        $('#daterange-input').attr('data-picker', true);
                    }

                    $('#daterange-input').click();
                },
            };
        })(jQuery, jQuery.fn.dataTable);
    </script>
@endpush
