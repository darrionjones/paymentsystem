<div class="sidebar" data-color="ebits-blue">
    <div class="app-sidebar">
        <!--
      Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
  -->
        <div class="logo">
            <img class="img-responsive" width="150" src="{{asset('assets/img/ebits-logo.png')}}" alt="">
            <a href="#" class="simple-text logo-normal">
                Payment System
                <span></span>
            </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
            <ul class="nav">
                
                <li class="@if ($activePage == 'dashboard-page') active @endif">
                    <a href="{{ route('merchants.dashboard.index', auth()->id()) }}">
                        <i class="fa-solid fa-link"></i>
                        <p> Dashboard </p>
                    </a>
                </li>


                <li class="@if ($activePage == 'transactions') active @endif">
                    <a href="{{ route('merchants.transactions.index') }}">
                        <i class="fa-solid fa-money-check"></i>
                        <p> Transactions </p>
                    </a>
                </li>
                @role('merchant')
                    <li class="@if ($activePage == 'payment-pages') active @endif">
                        <a href="{{ route('merchants.payment-page.index') }}">
                            <i class="fa-solid fa-link"></i>
                            <p> Payment Pages </p>
                        </a>
                    </li>
                @endrole
                @role('merchant')
                <li class="@if ($activePage == 'bank-pages') active @endif">
                    <a href="{{ route('bank.index') }}">
                        <i class="fa-solid fa-link"></i>
                        <p> Bank</p>
                    </a>
                </li>
            @endrole
                @role('admin')
                    <li class="@if ($activePage == 'merchants') active @endif">
                        <a href="{{ route('merchants.index') }}">
                            <i class="fa-solid fa-store"></i>
                            <p> Merchants </p>
                        </a>
                    </li>
                    {{-- payouts --}}
                    <li class="@if ($activePage == 'payouts') active @endif">
                        <a href="{{route('payouts.index',[
                            'status' => 'initiated'
                        ])}}">
                            <i class="fa-solid fa-store"></i>
                            <p> Payouts </p>
                        </a>
                    </li>
                @endrole
                <li class="@if ($activePage == 'users') active @endif">
                    <a href="{{ route('users.index') }}">
                        <i class="fa-solid fa-users-gear"></i>
                        <p> {{ __('User Management') }} </p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
