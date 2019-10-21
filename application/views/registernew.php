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

					<div class="span7">
						<h4 class="title"><span class="text"><strong>Register</strong> Form</span></h4>

						<?php
			        if(isset($error))
			          echo $error;

			        if(isset($activation))
			          echo $activation;
			          
			          $date=date('d/m/Y');
			       
			      ?>

						<form action="<?=base_url('index.php/dashboard/registerprocess')?>" method="post" class="form-stacked">
							<fieldset>
								<div class="control-group">
									<label class="control-label">First Name</label>
									<div class="controls">
										<input type="text" placeholder="Enter your First Name" required="required" value="<?php  if(isset($_POST['registerFirstName'])){ echo $fname=$_POST['registerFirstName']; } ?>"  oninvalid="this.setCustomValidity('Enter your first name')" oninput="this.setCustomValidity('')"  name="registerFirstName" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Last Name</label>
									<div class="controls">
										<input type="text" placeholder="Enter your Last Name" value="<?php  if(isset($_POST['registerLastName'])){ echo $_POST['registerLastName']; } ?>" required="required" oninvalid="this.setCustomValidity('Enter your last name')" oninput="this.setCustomValidity('')"  name="registerLastName" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Email address:</label>
									<div class="controls">
										<input type="email" name="registerEmail" required="required" value="<?php  if(isset($_POST['registerEmail'])){ echo $_POST['registerEmail']; } ?>" oninvalid="this.setCustomValidity('Enter your email address')" oninput="this.setCustomValidity('')"   placeholder="Enter your email" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Phone Number:</label>
									<div class="controls">
										<input type="text" name="registerPhone"  placeholder="Enter your Phone number" class="input-xlarge" onkeypress="isInputNumber(event)">
										        <script>
            
        											    function isInputNumber(evt){
                
            										    var ch = String.fromCharCode(evt.which);
             															   
            											    if(!(/[0-9]/.test(ch))){
               											     evt.preventDefault();
             												  }
              
           												 }
            
       											 </script>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Birth Day:</label>
									<div class="controls">
										<input type="date" id="datepicker" name="registerBirthday" required="required" oninvalid="this.setCustomValidity('Choose your birth day')" oninput="this.setCustomValidity('')"   placeholder="Enter birth Day" max="<?php echo $date;?>" value="<?php  if(isset($_POST['registerBirthday'])){ echo $_POST['registerBirthday']; } ?>" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Address:</label>
									<div class="controls">
										<input type="text" name="registerAddress" required="required" value="<?php  if(isset($_POST['registerAddress'])){ echo $_POST['registerAddress']; } ?>" oninvalid="this.setCustomValidity('Enter your present address')" oninput="this.setCustomValidity('')"   placeholder="Enter your address" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Password:</label>
									<div class="controls">
										<input type="password" name="registerPassword" required="required"  oninvalid="this.setCustomValidity('Enter your password')" oninput="this.setCustomValidity('')"  placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Re-Enter Password:</label>
									<div class="controls">
										<input type="password" name="registerReenter" required="required" oninvalid="this.setCustomValidity('Enter reenter your password')" oninput="this.setCustomValidity('')"   placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>
								<hr>
								<div class="actions"><input tabindex="9" class="btn btn-inverse large" type="submit" value="Create your account"> <a tabindex="4"  class="btn" href="<?php echo base_url('index.php/dashboard/login'); ?>" title="Click to login ">Already have account? </a></div>
								<hr/>
								
							</fieldset>
						</form>
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
		<script>
			$(document).ready(function() {
				$('#checkout').click(function (e) {
					document.location.href = "checkout.html";
				});
				
			});
		</script>
