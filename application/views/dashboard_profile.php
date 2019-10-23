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
			<section class="main-content">
				<!-- -->

				<div class="navbar-inner">
					<nav id="menu" class="pull-left">
						<ul>
							<li><a href="<?php echo base_url('/index.php/dashboard'); ?>">Calendar</a></li>
							<li><a href="<?php echo base_url('/index.php/dashboard/profile'); ?>">Profile</a></li>

							<?php
								if($this->ion_auth->in_group("admin"))
								{
									echo '<li><a href="'.base_url('index.php/dashboard/appointment').'">Appointments</a></li>';
									echo '<li><a href="'.base_url('index.php/dashboard/services').'">Services</a></li>';
									echo '<li><a href="'.base_url('index.php/dashboard/users').'">Users</a></li>';
								}
							?>

							<li><a href="<?php echo base_url('index.php/dashboard/logout'); ?>">Logout</a></li>
						</ul>
					</nav>
				</div>

				<br>

				<?php
					$lastName = "";
					$firstName = "";
					$email = "";
					$number = "";
					$birthday = "";
					$address = "";

					if(isset($userDetails))
					{
						$lastName = $userDetails[0]['last_name'];
						$firstName = $userDetails[0]['first_name'];
						$email = $userDetails[0]['email'];
						$number = $userDetails[0]['phone'];
						$birthday = $userDetails[0]['user_extra_info_birthday'];;
						$address = $userDetails[0]['user_extra_info_address'];;
					}
				?>

				<?php
	        if(isset($error))
	          echo $error;

	        if(isset($activation))
	          echo $activation;

					if(isset($message))
	          echo $message;
	      ?>

				<div>
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Profile Details</th>
						</tr>
					</thead>
					<tbody>
						<form class="login_form" action="<?=base_url('index.php/dashboard/changeProfile')?>" method="post" >
						<tr>
							<td>
								<div class="control-group">
									<label class="control-label">First Name</label>
									<div class="controls">
										<input type="text" placeholder="Enter your First Name" name="registerFirstName" class="input-xlarge" value="<?php echo $firstName;?>" >
									</div>
								</div>
							</td>
							<td>
								<div class="control-group">
									<label class="control-label">Last Name</label>
									<div class="controls">
										<input type="text" placeholder="Enter your last Name" name="registerLastName" class="input-xlarge" value="<?php echo $lastName;?>" >
									</div>
								</div>
							</td>
						</tr>
						
						<tr>
							<td>
								<div class="control-group">
									<label class="control-label">Email address:</label>
									<div class="controls">
										<input type="email" name="registerEmail"  placeholder="Enter your email" class="input-xlarge" value="<?php echo $email;?>" >
									</div>
								</div>
							</td>
							<td>
								<div class="control-group">
									<label class="control-label">Phone Number:</label>
									<div class="controls">
										<input type="text" name="registerPhone"  placeholder="Enter your Phone number" class="input-xlarge" value="<?php echo $number;?>" >
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="control-group">
									<label class="control-label">Birth Day:</label>
									<div class="controls">
										<input type="date" name="registerBirthday"  placeholder="Enter birth Day" class="input-xlarge" value="<?php echo $birthday;?>" >
									</div>
								</div>
							</td>
							<td>
								<div class="control-group">
									<label class="control-label">Address:</label>
									<div class="controls">
										<input type="text" name="registerAddress"  placeholder="Enter your address" class="input-xlarge" value="<?php echo $address;?>" >
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<input type="submit" value="Save Details">
							</td>
							<td>
							</td>
						</tr>
						</form>
						<form class="login_form" id="formchangepass" action="<?php echo base_url('index.php/dashboard/changePassword')?>" method="post" >
						<tr>
							<td>
								<div class="control-group">
									<label class="control-label">Enter Old Password:</label>
									<div class="controls">
										<input type="password" name="oldPassword"  placeholder="Enter your password" class="input-xlarge">
									</div>
								</div>
							</td>
							<td>
								<div class="control-group">
									<label class="control-label">Enter New Password:</label>
									<div class="controls">
										<input type="password" name="newPassword"  placeholder="Enter your new password" class="input-xlarge">
										<br>
										<input type="password" name="newPasswordConfirm"  placeholder="Confirm your new password" class="input-xlarge">
									</div>
								</div>
							</td>
						</tr>
						</form>
					</tbody>
					<tfoot>
						<tr>
							<td>
								<input type="submit" value="Save Password" form="formchangepass">
							</td>
							<td>
							</td>
						</tr>
					</tfoot>
				</table>
				</div>

				<div class="loader-inner line-scale-pulse-out" id="wait">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>

				<!-- -->
			</section>
			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>

		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>

      function changePassword()
      {
        var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/dashboard/changePassword/";

				var form = $("#formServiceAdd");

        $('#wait').show();
        $.ajax({
					type: "POST",
          url : url,
					dataType: "JSON",
          data: form.serialize(),
          success: function(data)
          {
            if(data.status)
            {
              toaster.success('Service added.');
							location.reload();
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              // /document.getElementById("message").innerHTML = jqXHR.responseText;
          },
          complete: function(){
            $('#wait').hide();
          }
        });
      }

    </script>
