<!-- jQuery -->
<script src="{{ asset('/assets/admin/assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ asset('/assets/admin/assets/js/feather.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('/assets/admin/assets/js/jquery.slimscroll.min.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ asset('/assets/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ asset('/assets/admin/assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/plugins/apexchart/chart-data.js') }}"></script>

<!-- Sweetalert 2 -->
<script src="{{ asset('/assets/admin/assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<!-- Swiper JS -->
<script src="{{ asset('/assets/admin/assets/plugins/swiper/swiper.min.js') }}"></script>

<!-- FancyBox JS -->
<script src="{{ asset('/assets/admin/assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>

<!-- Select2 JS -->
<script src="{{ asset('/assets/admin/assets/plugins/select2/js/select2.min.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ asset('/assets/admin/assets/js/moment.min.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

@if (Route::is(['todo']))
    <!-- Datetimepicker CSS -->
    <script src="{{ asset('/assets/admin/assets/plugins/moment/moment.min.js') }}"></script>
@endif

<!-- Bootstrap Tagsinput JS -->
<script src="{{ asset('/assets/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

<!-- Datatable JS -->
<script src="{{ asset('/assets/admin/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/js/dataTables.bootstrap5.min.js') }}"></script>

<!-- Summernote JS -->
<script src="{{ asset('/assets/admin/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- Mobile Input -->
<script src="{{ asset('/assets/admin/assets/plugins/intltelinput/js/intlTelInput.js') }}"></script>

<script src="{{ asset('/assets/admin/assets/js/plyr-js.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('/assets/admin/assets/js/owl.carousel.min.js') }}"></script>

<!-- Sticky-sidebar -->
<script src="{{ asset('/assets/admin/assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

@if (Route::is(['sales-dashboard']))
    <!-- Map JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-ru-mill.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-uk_countries-mill.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/jvectormap/jquery-jvectormap-in-mill.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/js/jvectormap.js') }}"></script>
@endif

@if (Route::is('calendar'))
    <!-- Full Calendar JS -->
    <script src="{{ asset('/assets/admin/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
@endif

@if (Route::is(['ui-clipboard']))
    <!-- Clipboard JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endif

@if (Route::is(['ui-drag-drop']))
    <!-- Dragula JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/dragula/js/dragula.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/dragula/js/drag-drop.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/dragula/js/draggable-cards.js') }}"></script>
@endif

@if (Route::is(['ui-rating']))
    <!-- Rater JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/rater-js/index.js') }}"></script>
    <!-- Internal Ratings JS -->
    <script src="{{ asset('/assets/admin/assets/js/ratings.js') }}"></script>
@endif

@if (Route::is(['ui-counter']))
    <!-- Stickynote JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/countup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/countup/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/countup/jquery.missofis-countdown.js') }}"></script>
@endif

@if (Route::is(['ui-text-editor']))
    <!-- Summernote JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endif

@if (Route::is(['ui-rangeslider']))
    <!-- Rangeslider JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/ion-rangeslider/js/custom-rangeslider.js') }}"></script>
@endif

@if (Route::is(['form-mask']))
    <!-- Mask JS -->
    <script src="{{ asset('/assets/admin/assets/js/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/js/mask.js') }}"></script>
@endif

@if (Route::is(['ui-scrollbar']))
    <!-- Plyr JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/scrollbar/scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/scrollbar/custom-scroll.js') }}"></script>
@endif

@if (Route::is(['ui-stickynote']))
    <!-- Stickynote JS -->
    <script src="{{ asset('/assets/admin/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/stickynote/sticky.js') }}"></script>
@endif

@if (Route::is(['ui-toasts']))
    <!-- Mask JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/toastr/toastr.js') }}"></script>
@endif

@if (Route::is(['ui-lightbox']))
    <script src="{{ asset('/assets/admin/assets/plugins/lightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/lightbox/lightbox.js') }}"></script>
@endif

@if (Route::is(['chart-c3']))
    <!-- Chart JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/c3-chart/d3.v5.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/c3-chart/c3.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/c3-chart/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-flot']))
    <!-- Chart JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/flot/chart-data.js') }}"></script>
@endif

@if (Route::is(['lightbox']))
    <!-- lightbox JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/lightbox/glightbox.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/lightbox/lightbox.js') }}"></script>
@endif

@if (Route::is(['chart-js']))
    <!-- Chart JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/chartjs/chart.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/chartjs/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-morris']))
    <!-- Chart JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/morris/chart-data.js') }}"></script>
@endif

@if (Route::is(['chart-peity']))
    <!-- Chart JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/peity/chart-data.js') }}"></script>
@endif

@if (Route::is(['form-select2']))
    <script src="{{ asset('/assets/admin/assets/js/custom-select2.js') }}"></script>
@endif

@if (Route::is(['form-fileupload']))
    <!-- Fileupload JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/fileupload/fileupload.min.js') }}"></script>
@endif

@if (Route::is(['form-wizard']))
    <!-- Wizard JS -->
    <script src="{{ asset('/assets/admin/assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}">
    </script>
    <script src="{{ asset('/assets/admin/assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
    <script src="{{ asset('/assets/admin/assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
@endif


@if (Route::is(['product-add', 'stock-add-form', 'pos', 'order-add-form']))
    <script src="{{ asset('/assets/admin/assets/js/custom-select2.js') }}"></script>
@endif

@if (Route::is(['pos']))
    <script src="{{ asset('/assets/admin/assets/js/page/pos.js') }}"></script>
@endif

@if (Route::is(['order', 'order-add-form']))
    <script src="{{ asset('/assets/admin/assets/js/page/order.js') }}"></script>
@endif

<!-- Custom JS -->
<script src="{{ asset('/assets/admin/assets/js/theme-script.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/js/script.js') }}"></script>
<script src="{{ asset('/assets/admin/assets/js/form.js') }}"></script>
