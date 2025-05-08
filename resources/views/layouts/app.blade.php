<!doctype html>

<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-skin="default"
    data-assets-path="{{ asset('/') }}assets/" data-template="vertical-menu-template-no-customizer-starter"
    data-bs-theme="light">

    @include('layouts.partials.header')

    <body>
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('layouts.partials.sidebar')

                <!-- Layout container -->
                <div class="layout-page">
                    @include('layouts.partials.navbar')

                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        @yield('content')

                        @include('layouts.partials.footer')

                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
            @stack('modals')
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/theme.js -->

        <script src="{{ asset('/') }}assets/vendor/libs/jquery/jquery.js"></script>

        <script src="{{ asset('/') }}assets/vendor/libs/popper/popper.js"></script>
        <script src="{{ asset('/') }}assets/vendor/js/bootstrap.js"></script>
        <script src="{{ asset('/') }}assets/vendor/libs/node-waves/node-waves.js"></script>

        <script src="{{ asset('/') }}assets/vendor/libs/@algolia/autocomplete-js.js"></script>

        <script src="{{ asset('/') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="{{ asset('/') }}assets/vendor/libs/hammer/hammer.js"></script>

        <script src="{{ asset('/') }}assets/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <!-- Vendors JS -->
        <script src="{{ asset('/') }}assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <!-- Flat Picker -->
        <script src="{{ asset('/') }}assets/vendor/libs/moment/moment.js"></script>
        <script src="{{ asset('/') }}assets/vendor/libs/flatpickr/flatpickr.js"></script>
        <!-- Form Validation -->
        <script src="{{ asset('/') }}assets/vendor/libs/@form-validation/popular.js"></script>
        <script src="{{ asset('/') }}assets/vendor/libs/@form-validation/bootstrap5.js"></script>
        <script src="{{ asset('/') }}assets/vendor/libs/@form-validation/auto-focus.js"></script>
        <script src="{{ asset('/') }}assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

        <!-- Main JS -->

        <script src="{{ asset('/') }}assets/js/main.js"></script>
        @stack('scripts')

        <!-- Page JS -->
    </body>

</html>
