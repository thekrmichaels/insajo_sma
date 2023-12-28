<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ url('/home') }}" class="brand-link">
        {{-- <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" alt="{{ config('app.name') }} Logo"
            class="brand-image img-circle elevation-3"> --}}
        <img src="../images/Logo.png" height ="40" width="40">
        <font color="white">
                <span class="brand-text font-weight-light">
                    <strong>
                        &nbsp;
                        {{ config('app.name') }}
                    </strong>
                </span>
        </font>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @include('layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
