@include('layouts.header')

<body
    data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
<!-- Begin page -->
<div class="wrapper">
    @include('layouts.sidebar')

    <div class="content-page">
        <div class="content">
            <!-- Topbar Start -->
            @include('layouts.navbar')
            <!-- end Topbar -->
            <!-- Start Content-->
            <div class="container-fluid mt-2">
                <!-- start page title -->
                <div class="row">
                    @include('layouts.errors')
                    @yield('content')
                </div>
                <!-- end page title -->

            </div>
            <!-- container -->
        </div>
        <!-- content -->
@include('layouts.footer')
