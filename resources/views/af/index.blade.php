@extends('layouts.main')

@section('content')
    <div class="container-fluid">

        <div class="row">

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-primary p-3 mfe-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-value text-primary">{{ number_format($totalAffiliate) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Active Affiliates') }}</div>
                        </div>
                    </div>
                    <div class="card-footer px-3 py-2"><a
                                class="btn-block text-muted d-flex justify-content-between align-items-center"
                                href="#"><span class="small font-weight-bold">View More</span>
                            <i class="fas fa-chevron-right"></i>
                        </a></div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-info p-3 mfe-3">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <div class="text-value text-info">{{ number_format($totalActiveClient) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Active Clients') }}</div>
                        </div>
                    </div>
                    <div class="card-footer px-3 py-2"><a
                                class="btn-block text-muted d-flex justify-content-between align-items-center"
                                href="#"><span class="small font-weight-bold">View More</span>
                            <i class="fas fa-chevron-right"></i>
                        </a></div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-warning p-3 mfe-3">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div>
                            <div class="text-value text-warning">${{ number_format($totalThisWeekCommission, 2) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">{{ __('Total Commission') }}</div>
                        </div>
                    </div>
                    <div class="card-footer px-3 py-2"><a
                                class="btn-block text-muted d-flex justify-content-between align-items-center"
                                href="#"><span class="small font-weight-bold">View More</span>
                            <i class="fas fa-chevron-right"></i>
                        </a></div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card">
                    <div class="card-body p-3 d-flex align-items-center">
                        <div class="bg-danger p-3 mfe-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="text-value text-danger">{{ number_format(0) }}</div>
                            <div class="text-muted text-uppercase font-weight-bold small">{{ __('Referral Bonus') }}</div>
                        </div>
                    </div>
                    <div class="card-footer px-3 py-2"><a
                                class="btn-block text-muted d-flex justify-content-between align-items-center"
                                href="#"><span class="small font-weight-bold">View More</span>
                            <i class="fas fa-chevron-right"></i>
                        </a></div>
                </div>
            </div>

        </div>
    </div>
@endsection
