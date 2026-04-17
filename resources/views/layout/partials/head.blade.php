<!-- =========================
     CORE CSS (build/css)
========================= -->
<link rel="stylesheet" href="{{ url('build/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ url('build/css/animate.css') }}">
<link rel="stylesheet" href="{{ url('build/css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ url('build/css/dataTables.bootstrap5.min.css') }}">
<link rel="stylesheet" href="{{ url('build/css/feather.css') }}">
<link rel="stylesheet" href="{{ url('build/css/plyr.css') }}">
<link rel="stylesheet" href="{{ url('build/css/owl.carousel.min.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" href="{{ url('build/css/style.css') }}">


<!-- =========================
     DATE / TIME
========================= -->
<link rel="stylesheet" href="{{ url('build/plugins/daterangepicker/daterangepicker.css') }}">


<!-- =========================
     FORMS & INPUT PLUGINS
========================= -->
<link rel="stylesheet" href="{{ url('build/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/intltelinput/css/intlTelInput.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/intltelinput/css/demo.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">


<!-- =========================
     EDITOR & MEDIA
========================= -->
<link rel="stylesheet" href="{{ url('build/plugins/summernote/summernote-bs4.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/fancybox/jquery.fancybox.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/lightbox/glightbox.min.css') }}">


<!-- =========================
     UI / ANIMATION / EFFECTS
========================= -->
<link rel="stylesheet" href="{{ url('build/css/animate.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/stickynote/sticky.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/scrollbar/scroll.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/toastr/toatr.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/dragula/css/dragula.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/swiper/swiper.min.css') }}">


<!-- =========================
     TABLES & CHARTS / DATA
========================= -->
<link rel="stylesheet" href="{{ url('build/plugins/fullcalendar/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/jvectormap/jquery-jvectormap-2.0.5.css') }}">


<!-- =========================
     ICONS
========================= -->
<link rel="stylesheet" href="{{ url('build/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/fontawesome/css/all.min.css') }}">

<link rel="stylesheet" href="{{ url('build/plugins/boxicons/css/boxicons.min.css') }}">

<link rel="stylesheet" href="{{ url('build/plugins/icons/feather/feather.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/flags/flags.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/ionic/ionicons.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/material/materialdesignicons.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/pe7/pe-icon-7.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/simpleline/simple-line-icons.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/themify/themify.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/typicons/typicons.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/icons/weather/weathericons.css') }}">


<!-- =========================
     MEDIA / CAROUSEL
========================= -->
<link rel="stylesheet" href="{{ url('build/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ url('build/plugins/swiper/swiper.min.css') }}">


<!-- =========================
     SPECIAL CASE BY ROUTE
========================= -->
@if (Route::is(['sales-dashboard']))
    <link rel="stylesheet" href="{{ url('build/plugins/jvectormap/jquery-jvectormap-2.0.5.css') }}">
@endif

@if (Route::is(['calendar']))
    <link rel="stylesheet" href="{{ url('build/plugins/fullcalendar/fullcalendar.min.css') }}">
@endif

@if (Route::is(['ui-stickynote', 'ui-timeline']))
    <link rel="stylesheet" href="{{ url('build/plugins/stickynote/sticky.css') }}">
@endif

@if (Route::is(['ui-scrollbar']))
    <link rel="stylesheet" href="{{ url('build/plugins/scrollbar/scroll.min.css') }}">
@endif

@if (Route::is(['ui-toasts']))
    <link rel="stylesheet" href="{{ url('build/plugins/toastr/toatr.css') }}">
@endif

@if (Route::is(['ui-lightbox']))
    <link rel="stylesheet" href="{{ url('build/plugins/lightbox/glightbox.min.css') }}">
@endif

@if (Route::is(['ui-clipboard', 'ui-drag-drop']))
    <link rel="stylesheet" href="{{ url('build/plugins/dragula/css/dragula.min.css') }}">
@endif

@if (Route::is(['icon-feather']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/feather/feather.css') }}">
@endif

@if (Route::is(['icon-flag']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/flags/flags.css') }}">
@endif

@if (Route::is(['icon-ionic']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/ionic/ionicons.css') }}">
@endif

@if (Route::is(['icon-material']))
    <link rel="stylesheet" href="{{ url('build/plugins/material/materialdesignicons.css') }}">
@endif

@if (Route::is(['icon-pe7']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/pe7/pe-icon-7.css') }}">
@endif

@if (Route::is(['icon-simpleline']))
    <link rel="stylesheet" href="{{ url('build/plugins/simpleline/simple-line-icons.css') }}">
@endif

@if (Route::is(['icon-themify']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/themify/themify.css') }}">
@endif

@if (Route::is(['icon-typicon']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/typicons/typicons.css') }}">
@endif

@if (Route::is(['icon-weather']))
    <link rel="stylesheet" href="{{ url('build/plugins/icons/weather/weathericons.css') }}">
@endif


<!-- =========================
     OPTIONAL UI COMPONENTS
========================= -->
@if (Route::is(['form-wizard']))
    <link rel="stylesheet" href="{{ url('build/plugins/twitter-bootstrap-wizard/form-wizard.css') }}">
@endif