@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    {{ __('Statistic and Report') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Top Looser') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.reports.statistics.top-looser') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Top Commission and OR Producer') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.reports.statistics.top-commission') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4  mb-4">
                            <h3>{{ __('Top New Member Producer') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.reports.statistics.top-new-member') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Top Gainer') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.reports.statistics.top-gainer') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Last Member Transaction') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.withdrawals.index') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

{{--                        <div class="col-sm-4 mb-4">--}}
{{--                            <span class="badge badge-danger small">Coming Soon</span>--}}
{{--                            <h3>{{ __('Last Initial Margin') }}</h3>--}}
{{--                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>--}}
{{--                            <a class="btn btn-outline-info">{{ __('See Report') }}</a>--}}
{{--                        </div>--}}

{{--                        <div class="col-sm-4 mb-4">--}}
{{--                            <span class="badge badge-danger small">Coming Soon</span>--}}
{{--                            <h3>{{ __('Most Active Member') }}</h3>--}}
{{--                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>--}}
{{--                            <a class="btn btn-outline-info">{{ __('See Report') }}</a>--}}
{{--                        </div>--}}

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Symbol Statistic') }}</h3>
                            <p>Displaying statistic about Symbol transaction like total position, total lot, total profit</p>
                            <a  href="{{ route('console.reports.statistics.symbol') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Closed Order By LQ Time') }}</h3>
                            <p>{{ __('Displaying closed order who closed less than 3 minutes.') }}</p>
                            <a href="{{ route('console.closed-order-by-lq.index') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>

                        <div class="col-sm-4 mb-4">
                            <h3>{{ __('Affiliate Commission') }}</h3>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="{{ route('console.reports.statistics.affiliate-commission') }}" class="btn btn-outline-info">{{ __('See Report') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
