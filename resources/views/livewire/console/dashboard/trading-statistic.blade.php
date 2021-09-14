<div wire:init="initialLoading">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{ __('Trading Statistic') }}</h4>
                    <div class="small text-muted">{{ __('Show statistic about Trading Symbol') }}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" wire:ignore>
                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <h6 class="mt-3">{{ __('Symbol Statistic Table') }}</h6>
                    <div class="table-responsive" >
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('Symbol') }}</th>
                                <th>{{ __('Total Position') }}</th>
                                <th>{{ __('Total Lot') }}</th>
                                <th>{{ __('Total Profit/Loss') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr wire:loading.inline>
                                <td colspan="4" class="text-center">{{ __('Loading') }}</td>
                            </tr>

                            @forelse($records as $r)
                                <tr>
                                    <td>
                                        <div>{{ $r->symbol }}</div>
                                        <div class="small text-muted"><span class="text-success">{{ $r->bid }}</span> / <span class="text-danger">{{ $r->ask }}</span></div>
                                    </td>
                                    <td>{{ number_format($r->total_position) }}</td>
                                    <td>{{ number_format($r->total_lot, 2) }}</td>
                                    <td>{{ number_format($r->total_profit,2) }}</td>
                                </tr>
                            @empty
                                <tr wire:loading.remove>
                                    <td colspan="4" class="text-center">{{ __('No Records') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mt-3">{{ __('Closed Order Liquidity Time') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('Ticket') }}</th>
                                <th>{{ __('Symbol') }}</th>
                                <th>{{ __('Login') }}</th>
                                <th>{{ __('Open Time') }}</th>
                                <th>{{ __('Close Time') }}</th>
                                <th>{{ __('Liquidity Time') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr wire:loading.inline>
                                <td colspan="4" class="text-center">{{ __('Loading') }}</td>
                            </tr>

                            @forelse($orders as $o)
                                <tr>
                                    <td>
                                        {{ $o->TICKET }}
                                    </td>
                                    <td>
                                        {{ $o->SYMBOL }}
                                    </td>
                                    <td>
                                        {{ $o->LOGIN }}
                                    </td>
                                    <td>
                                        {{ $o->OPEN_TIME }}
                                    </td>
                                    <td>
                                        {{ $o->CLOSE_TIME }}
                                    </td>
                                    <td>
                                        {{ number_format($o->LQ_TIME, 2) }} Minute
                                    </td>
                                </tr>
                            @empty
                                <tr wire:loading.remove>
                                    <td colspan="4" class="text-center">{{ __('No Records') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <h6 class="mt-3">{{ __('Most Active Trader') }}</h6>
                    <div class="table-responsive">
                        <table class="table table-responsive-sm table-hover table-outline mb-0">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ __('Client') }}</th>
                                <th>{{ __('Total Position') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr wire:loading.inline>
                                <td colspan="2" class="text-center">{{ __('Loading') }}</td>
                            </tr>

                            @forelse($mostOrders as $r)
                                <tr>
                                    <td>
                                        <div>{{ $r->NAME }}</div>
                                        <div class="small text-muted"><span>{{ $r->LOGIN }}</span></div>
                                    </td>
                                    <td>{{ number_format($r->TOTAL) }}</td>
                                </tr>
                            @empty
                                <tr wire:loading.remove>
                                    <td colspan="4" class="text-center">{{ __('No Records') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
