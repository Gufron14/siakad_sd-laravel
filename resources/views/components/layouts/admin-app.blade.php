<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('components.title-meta')
    @include('components.head')
</head>

@section('body')

    <body>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('components.topbar')
        @include('components.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            {{-- @include('components.footer') --}}
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('components.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('components.vendor-scripts')
</body>

</html>
