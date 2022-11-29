<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{Settings::get('application_title')}} - Coming Soon</title>
<link rel="stylesheet" href="{{ asset('assets/front/js/main.css') }}" media="all">
<script src="{{ asset('assets/front/js/jquery-1.12.4.min.js') }}"></script>
</head>

<body class="">
	<div id="page">
		<header class="site-header light-color">
			<div class="container">
				<div class="row align-items-center justify-content-between">
					<div class="logo-block col-auto">
						<div class="site-logo">
							<a href="#">
								<img class="light" src="{{ url(\Settings::get('application_logo')) }}" alt="Somo">
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>

		<section class="banner-area coming-soon-banner bsl-left">
			<div class="banner-item">
				<div class="bg-overlay">
					<div class="image" style="background-image: url(assets/front/img/backgroud.jpg);">
					</div>
				</div>
				<div class="container" style="text-align: center;">
					<div class="row align-items-center full-height" style="height: 237px;">
						<div class="col-12">
							<div class="heading-block" style="color:#FFF">
								<div class="h h2">Coming Soon</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script src="{{ asset('assets/front/js/swiper.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/scripts.js') }}"></script>
</body>
</html>