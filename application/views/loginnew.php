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
			<section class="header_text sub">
			<img class="pageBanner" src="<?php echo base_url('asset/include/themes/images/pageBanner.png'); ?>" alt="New products" >
				<h4><span>Login or Regsiter</span></h4>
			</section>
			<section class="main-content">
				<div class="row">
					<div class="span4">
					</div>
					<div class="span5">
						<h4 class="title"><span class="text"><strong>Login</strong> Form</span></h4>
						<?php
					        if(isset($message))
					          echo $message;

					        if(isset($activation))
					          echo $activation;

					      ?>
						<form action="<?=base_url('index.php/dashboard/login')?>" method="post">
							<input type="hidden" name="next" value="/">
							<fieldset>
								<div class="control-group">
									<label class="control-label">Username / Email</label>
									<div class="controls">
										<input type="text" placeholder="Enter your username"  required="required"  name="identity" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Password</label>
									<div class="controls">
										<input type="password" placeholder="Enter your password"   required="required"  name="password" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<input tabindex="3" class="btn btn-inverse large" type="submit" value="Sign into your account"> <a tabindex="4" class="btn" href="<?php echo base_url('index.php/dashboard/register'); ?>" title="Click to Signup ">Click to Signup </a>
								</div>
							</fieldset>
						</form>
					</div>
				</div>

				<div class="row">
					<div class="span4">
					</div>
					<div class="span5">
						<h4 class="title"><span class="text"><strong>Forgot Password</strong> Form</span></h4>
						<?php
					        if(isset($message))
					          echo $message;

					        if(isset($activation))
					          echo $activation;

					      ?>
						<form action="<?=base_url('index.php/dashboard/forgotPassword')?>" method="post">
							<input type="hidden" name="next" value="/">
							<?php
								if(isset($passwordReset))
								{
									echo $passwordReset;
								}
							?>
							<fieldset>
								<div class="control-group">
									<label class="control-label">Email</label>
									<div class="controls">
										<input type="text" placeholder="Enter your email"  required="required"  name="email" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<input tabindex="3" class="btn btn-inverse large" type="submit" value="Reset Password">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</section>
			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>
		<script>
			$(document).ready(function() {
				$('#checkout').click(function (e) {
					document.location.href = "checkout.html";
				})
			}); 
		</script>
