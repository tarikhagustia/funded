<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img class="c-sidebar-brand-full img-fluid" src="{{ asset('images/logo.png') }}" style="width: 150px"><span class="font-weight-bold text-white">BETA</span>
{{--        <svg class="c-sidebar-brand-minimized" width="46" height="46" alt="CoreUI Logo">--}}
{{--            <use xlink:href="assets/brand/coreui.svg#signet"></use>--}}
{{--        </svg>--}}
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ url('/') }}">
            <i class="c-sidebar-nav-icon fas fa-home"></i>
            Dashboard</a></li>
{{--        <li class="c-sidebar-nav-title">Settings</li>--}}
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class="c-sidebar-nav-icon fas fa-users"></i>
                {{ __('Members') }}</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('af.af-member') }}">{{ __('My Affiliates') }}</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('af.treeview') }}">{{ __('Treeview') }}</a></li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                <i class="c-sidebar-nav-icon fas fa-file-invoice-dollar"></i>
                {{ __('My Commission') }}</a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('comm.realtime') }}">{{ __('Commission') }}</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('comm.referral_bonus') }}">{{ __('Referral Bonus') }}</a></li>
                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('comm.net_margin_bonus') }}">{{ __('Net Margin Bonus') }}</a></li>
            </ul>
        </li>
        @if(auth()->user()->level_on_group == 4 || (auth()->user()->parent && auth()->user()->parent->level_on_group == 4))
            <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a
                        class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="c-sidebar-nav-icon fa fa-dollar-sign"></i>
                    {{ __('Operating costs') }}</a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('costs-operation.approval') }}">{{ __('Costs Approval') }}</a></li>
                    @if(auth()->user()->parent)
                    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('costs-operation.request') }}">{{ __('Costs Request') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

{{--        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a--}}
{{--                    class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">--}}
{{--                <i class="c-sidebar-nav-icon fas fa-user-plus"></i>--}}
{{--                {{ __('AF Management') }}</a>--}}
{{--            <ul class="c-sidebar-nav-dropdown-items">--}}
{{--                <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{ route('console.affiliates.index') }}">{{ __('Affiliates') }}</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"--}}
{{--            data-class="c-sidebar-minimized"></button>--}}
</div>
