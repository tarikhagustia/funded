<div class="table-responsive">
<table class="table table-striped datatable display responsive nowrap">
    <thead>
    <tr>
        <td>#</td>
        <td>{{__('Account')}}</td>
        <td>{{__('Account Type')}}</td>
        <td>{{__('Currency')}}</td>
        <td>{{__('Acc Date')}}</td>
    </tr>
    </thead>
    <tbody>
    @foreach($client->accounts as $key => $account)
    <tr>
        <td>{{++$key}}</td>
        <td><a href="{{route('console.trading_accounts.view',$account->id)}}">{{$account->accountid}}</a></td>
        <td>{{$account->group->type_name}}</td>
        <td>{{$account->currency->symbol . $account->currency->rate}}</td>
        <td>{{$account->accdate}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
