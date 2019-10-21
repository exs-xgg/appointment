	<div id="top-bar" class="container">
			<div class="row">
				<div class="span4">
					<form method="POST" class="search_form">

					</form>
				</div>
				<div class="span8">
					<div class="account pull-right">
						<ul class="user-menu">
							<?php
								if(!$this->ion_auth->logged_in())
								{
									echo('<li><a href="'.base_url('index.php/dashboard/login').'">Login</a></li>');
								}
								else
								{
									$fullName = $this->ion_auth->user()->row();
									echo('<li><a href="'.base_url('index.php/dashboard/login').'">Hi '.$fullName->first_name.'!</a></li>');
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper" class="container">
			<section class="navbar main-menu">
				<div class="navbar-inner main-menu">
					<a href="<?php echo base_url(''); ?>" class="logo pull-left"><img src="<?php echo base_url('asset/include/themes/images/logos.png'); ?>" class="site_logo" alt=""></a>
					<nav id="menu" class="pull-right">
						<ul>
							<li><a href="<?php echo base_url(''); ?>">Home</a>
							</li>
							<li><a href="<?php echo base_url('index.php/about'); ?>">About Us</a></li>
							<li><a href="<?php echo base_url('index.php/contact'); ?>">Contact</a>
							</li>
							
						</ul>
					</nav>
				</div>
			</section>
			<section  class="homepage-slider" id="home-slider">
				<div class="flexslider">
					<ul class="slides">
						<li>
							<img src="<?php echo base_url('asset/include/themes/images/carousel/banner-1.jpg'); ?>" alt="" />
						</li>
						<li>
							<img src="<?php echo base_url('asset/include/themes/images/carousel/banner-2.jpg'); ?>" alt="" />
						</li>
					</ul>
				</div>
			</section>
			<section class="header_text">
				To enhance the dental health and well-being of Hispanics and ethnically diverse communities by providing
				<br/>quality dental services in a professional and caring environment.
			</section>
			<section class="main-content">
				<div class="row">
					<div class="span12">
						<div class="row">
							<div class="span12">
								<h4 class="title">
									<span class="pull-left"><span class="text"><span class="line">Feature <strong>Dental Treatment</strong></span></span></span>
									<span class="pull-right">
										<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
									</span>
								</h4>

								<div id="myCarousel" class="myCarousel carousel slide">
									<div class="carousel-inner">
										<div class="active item">
											<ul class="thumbnails">
												<?php
												 if(isset($services))
												 {
													 foreach($services as $values)
													 {
															echo '<li class="span3">';
															echo '	<div class="product-box">';
															echo '		<span class="sale_tag"></span>';
															echo '		<p><a href="#"><img src="themes/images/ladies/1.jpg" alt="" /></a></p>';
															echo '		<a href="#" class="title">'.$values['services_name'].'</a><br/>';
															echo '		<a href="#" class="category">'.$values['services_description'].'</a>';
															echo '		<p>Duration: '.$values['services_duration'].' Minutes</p>';
															echo '	</div>';
															echo '</li>';
													 }
												 }
												?>
											</ul>
										</div>

									</div>
								</div>
							</div>
						</div>

			</section>

			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>
		<script src="<?php echo base_url('asset/include/themes/js/jquery-1.7.2.min.js'); ?> "></script>
		<script type="text/javascript">
			$(function() {
				$(document).ready(function() {
					$('.flexslider').flexslider({
						animation: "fade",
						slideshowSpeed: 4000,
						animationSpeed: 600,
						controlNav: false,
						directionNav: true,
						controlsContainer: ".flex-container" // the container that holds the flexslider
					});
				});
			});
		</script>
