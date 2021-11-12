<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img class="c-sidebar-brand-full" src="{{ asset('images/logo-small.png') }}">
{{--        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">--}}
{{--            <use xlink:href="assets/brand/coreui.svg#signet"></use>--}}
{{--        </svg>--}}
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.') }}">
                <i class="c-sidebar-nav-icon fas fa-home"></i>
                Dashboard</a></li>
        @can('Operating Cost')
            <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.operating-costs.index') }}">
                    <i class="c-sidebar-nav-icon fas fa-dollar-sign"></i>
                    Operating costs</a></li>
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                        class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="c-sidebar-nav-icon fas fa-users"></i>
                    {{ __('Client Management') }}</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.clients.index') }}">{{ __('Clients') }}</a></li>
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.trading_accounts.index') }}">{{ __('Trading Accounts') }}</a></li>
                </ul>
            </li>
        @endcan

        @can('Affiliate')
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                        class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="c-sidebar-nav-icon fas fa-users"></i>
                    {{ __('Affiliates Management') }}</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.affiliates.index') }}">{{ __('Affiliates') }}</a></li>
                </ul>
            </li>
        @endcan

        @canany(['Users', 'Roles'])
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class="c-sidebar-nav-icon fas fa-users"></i>
                {{ __('User Management') }}
            </a>

            <ul class="c-sidebar-nav-dropdown-items">
                @can('Users')
                    <li class="c-sidebar-nav-item">
                        <a class="c-sidebar-nav-link" href="{{ route('console.users.index') }}">
                            {{ __('Users') }}
                        </a>
                    </li>
                @endcan

                @can('Roles')
                <li>
                    <a class="c-sidebar-nav-link" href="{{ route('console.roles.index') }}">
                        {{ __('Roles') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class="c-sidebar-nav-icon fas fa-file-invoice"></i>
                {{ __('Report') }}</a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('General Commission')
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.commissions.index') }}">{{ __('General Commission') }}</a></li>
                @endcan
            </ul>
{{--            <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.closed-order-by-lq.index') }}">{{ __('Closed Order By LQ Time') }}</a></li>--}}
{{--            </ul>--}}
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.reports.statistics.index') }}">{{ __('Statistic') }}</a></li>
            </ul>
        </li>

        {{--        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a--}}
{{--                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">--}}
{{--                <i class="c-sidebar-nav-icon fas fa-user-plus"></i>--}}
{{--                {{ __('AF Management') }}</a>--}}
{{--            <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.affiliates.index') }}">{{ __('Affiliates') }}</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}

{{--        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a--}}
{{--                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">--}}
{{--                <i class="c-sidebar-nav-icon fas fa-cogs"></i>--}}
{{--                {{ __('Setting') }}</a>--}}
{{--            <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.account-types.index') }}">{{ __('Account Types') }}</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
