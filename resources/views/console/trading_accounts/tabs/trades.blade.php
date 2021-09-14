<div class="table-responsive">
    <table class="table table-striped datatable">
        <thead>
        <tr>
            <td class="all">{{__('Ticket Number')}}</td>
            <td class="all">{{__('Currency Pair')}}</td>
            <td class="all">{{__('Lot')}}</td>
            <td class="all">{{__('Open Time')}}</td>
            <td class="all">{{__('Close Time')}}</td>
            <td class="all">{{__('Profit')}}</td>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td class="all">{{__('Ticket Number')}}</td>
            <td class="all">{{__('Currency Pair')}}</td>
            <td class="all">{{__('Lot')}}</td>
            <td class="all">{{__('Open Time')}}</td>
            <td class="all">{{__('Close Time')}}</td>
            <td class="all">{{__('Profit')}}</td>
        </tr>
        </tfoot>
        <tbody>
        @foreach($account->trades()->orderBy('OPEN_TIME', 'DESC')->get() as $key => $value)
        <tr>
            <td>{{$value->TICKET}}</td>
            <td>{{$value->SYMBOL}}</td>
            <td>{{$value->VOLUME / 100}}</td>
            <td>{{$value->OPEN_TIME}}</td>
            <td>{{$value->CLOSE_TIME}}</td>
            <td>{{$value->PROFIT}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
