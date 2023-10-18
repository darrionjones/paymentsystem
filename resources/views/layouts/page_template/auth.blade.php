<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('layouts.navbars.sidebar')
<div class="main-panel">
    @include('layouts.navbars.navs.auth')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @include('alerts.success')
                        @include('alerts.errors')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
