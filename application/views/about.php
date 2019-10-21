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
					<a href="<?php echo base_url(''); ?>"><img src="<?php echo base_url('asset/include/themes/images/logos.png'); ?>" class="site_logo" alt=""></a>
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
			<section style="height:65%;" class="header_text">
				<h4><span>ABOUT US</span></h4>
			<h4>Dr. Sico Dental Clinic</h4>
			<p> The service of competent,experienced destist is your best shot at improving your looks, for a brighter smile and more self confidence.
			<br>Finding the right dentist can help ensure that you are comfortable while undergoing the dental procedures because you have full trust
			<br>on whoever is wielding the instruments.
			<br><br>
			when it comes to excellent dental services, trust only the dentist with extensive year of experience in the field. Dr. Evelyn C. Sico, the
			<br>dentist has 20 years experince. you can't deny that 20 years of service can easily make someone the best one for the job! The Dental 
			<br>Clinic is known for gentle yet highly competent hands to give you a brigther smile that you can be proud of! No need to cover your
			<br>mouth with your hands when you laugh or smile because you rteeth can be as whiter and evenly spaced as you coukd ever wish for!
			</p>

			</section>

			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>
		<script src="themes/js/common.js"></script>
		<script src="themes/js/jquery.flexslider-min.js"></script>
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
