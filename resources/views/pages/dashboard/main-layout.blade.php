<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>ExpeedShop</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png"  href="{{ asset('dashboard/assets/img/logo-expeed3.png')}}">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->

	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/all.min.css')}}">
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/bootstrap/css/bootstrap.min.css')}}">
	<!-- owl carousel -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/owl.carousel.css')}}">
	<!-- magnific popup -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/magnific-popup.css')}}">
	<!-- animate css -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/animate.css')}}">
	<!-- mean menu css -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/meanmenu.min.css')}}">
	<!-- main style -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/main.css')}}">
	<!-- responsive -->
	<link rel="stylesheet" href="{{ url('build/plugins/dashboard/assets/css/responsive.css')}}">
	
	<style>  
        h1 {  
            text-align: center; /* Menengahka <h1> */  
            font-weight: bold;  
            margin-bottom: 20px;  
			color: aliceblue;
        }  
        p {  
            text-align: center; /* Menengahkan teks dalam <p> */  
            line-height: 1.6;  
			color: aliceblue;
        }  
    </style>  

</head>

<body>
				
	<!--PreLoader-->
	{{-- <div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
		</div>
	</div> --}}
	<!--PreLoader Ends-->
	@if (Route::is(['main']))
			@include('pages.dashboard.partials.index')
	@endif
	@if (Route::is(['single-product']))
		@include('pages.dashboard.partials.single-product')
	@endif

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div style="display: flex; justify-content: center;">
				<img src="{{ asset('/build/plugins/dashboard/assets/img/logo-exspeed3.png')}}" alt="logo">
			</div>
			<br>
			<h1>ABOUT US</h1>  

			<p>  
				Buy various products at the Xspeedshop Store online now. You can buy products from the   
				Xspeedshop Store safely & easily from Bandung City. Want to shop more economically &   
				affordably at the Xspeedshop Store? You can use the 0% Installment feature from   
				various banks and the Free Shipping feature at the Xspeedshop Store so you can shop   
				online comfortably at Tokopedia. Buy various latest products at the Xspeedshop Store   
				easily from the palm of your hand using the Tokopedia Application. Also keep checking   
				the Xspeedshop Store for updates on Products, Voucher Codes to the Latest Promos   
				from the Latest Xspeedshop Store online at Tokopedia!  
			</p>  
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2025 - <a href="https://imransdesign.com/">Exspeed Shop</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery-1.11.3.min.js') }}">
		function formatRupiah(number) {
			let formattedNumber = number;
			
			// Ensure the input is a number or a valid string representation of a number
			if (typeof number === 'number' || !isNaN(number)) {
				formattedNumber = parseFloat(number).toFixed(2); // Parse and ensure two decimal places
			}

			// Replace the decimal point with a comma
			formattedNumber = formattedNumber.replace('.', ',');

			// Add thousands separators
			formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

			return formattedNumber;
			
		}
	</script>
	<!-- end copyright -->
	<!-- jquery -->            
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery-1.11.3.min.js') }}"></script>
	<!-- bootstrap -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/bootstrap/js/bootstrap.min.js') }}"></script>
	<!-- count down -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.countdown.js') }}"></script>
	<!-- isotope -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.isotope-3.0.6.min.js') }}"></script>
	<!-- waypoints -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/waypoints.js') }}"></script>
	<!-- owl carousel -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/owl.carousel.min.js') }}"></script>
	<!-- magnific popup -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.magnific-popup.min.js') }}"></script>
	<!-- mean menu -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/jquery.meanmenu.min.js') }}"></script>
	<!-- sticker js -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/sticker.js') }}"></script>
	<!-- main js -->
	<script src="{{ URL::asset('/build/plugins/dashboard/assets/js/main.js') }}"></script>

</body>
</html>