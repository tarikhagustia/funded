<div wire:init="initialLoading">
    <div class="card">
        <div class="card-header">{{ __('Client and Af Statistic') }}
            <div class="card-header-actions">
                <div id="reportrange-client"
                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" wire:ignore>
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="c-callout c-callout-info"><small class="text-muted">Total Deposit</small>
                                <div class="text-value-lg">${{ number_format($totalDeposit, 2) }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="c-callout c-callout-danger"><small class="text-muted">Total Withdrawal</small>
                                <div class="text-value-lg">${{ number_format($totalWithdrawal, 2) }}</div>
                            </div>
                        </div>

                    </div>

                    <hr class="mt-0">
                    <h6>{{ __('Top Gainer') }}</h6>
                    @foreach($gainers as $row)
                        <div class="d-flex align-items-center mb-2">
                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower($row->EMAIL)) }}" class="img-fluid rounded-circle" width="60">
                            <div class="ml-2">
                                <div>{{ $row->LOGIN }}</div>
                                <div class="text-muted">{{ $row->NAME }}</div>
                            </div>
                            <div class="ml-auto font-weight-bold">${{ number_format($row->TOTAL, 2) }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="c-callout c-callout-warning"><small
                                        class="text-muted">{{ __('Active AF') }}</small>
                                <div class="text-value-lg">{{ number_format($totalActiveAf) }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="c-callout c-callout-success"><small
                                        class="text-muted">{{ __('Inactive AF') }}</small>
                                <div class="text-value-lg">{{ number_format($totalInactiveAf) }}</div>
                            </div>
                        </div>

                    </div>

                    <hr class="mt-0">
                    <h6>{{ __('AF Gender Statistic') }}</h6>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <i class="fas fa-male p-1"></i>
                            <div>Male</div>
                            <div class="mfs-auto font-weight-bold">{{ number_format($totalAfMale / $totalAf *100, 2) }}%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalAfMale / $totalAf *100 }}%"
                                     aria-valuenow="{{ $totalAfMale / $totalAf *100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-5">
                        <div class="progress-group-header">
                            <i class="fas fa-female p-1"></i>
                            <div>Female</div>
                            <div class="mfs-auto font-weight-bold">{{ number_format($totalAfFemale / $totalAf *100,2) }}%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalAfFemale / $totalAf *100 }}%"
                                     aria-valuenow="{{ $totalAfFemale / $totalAf *100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                    <h6>{{ __('Client Gender Statistic') }}</h6>
                    <div class="progress-group">
                        <div class="progress-group-header">
                            <i class="fas fa-male p-1"></i>
                            <div>Male</div>
                            <div class="mfs-auto font-weight-bold">{{ number_format($totalClientMale / $totalClient *100, 2)}}%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalClientMale / $totalClient *100 }}%"
                                     aria-valuenow="{{ $totalClientMale / $totalClient *100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-group mb-5">
                        <div class="progress-group-header">
                            <i class="fas fa-female p-1"></i>
                            <div>Female</div>
                            <div class="mfs-auto font-weight-bold">{{ number_format($totalClientFemale / $totalClient *100, 2) }}%</div>
                        </div>
                        <div class="progress-group-bars">
                            <div class="progress progress-xs">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalClientFemale / $totalClient *100 }}%"
                                     aria-valuenow="{{ $totalClientFemale / $totalClient *100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
