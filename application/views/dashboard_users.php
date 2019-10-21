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

				<div class="tab-content">
					<table class="table table-hover">
				    <thead>
				      <tr>
				        <th>Last Name</th>
				        <th>First Name</th>
				        <th>Email Address</th>
				        <th>Phone</th>
				        <th>Birthday</th>
				        <th>Address</th>
								<th>Status</th>
								<th>Action</th>
				      </tr>
				    </thead>
				    <tbody>
							<?php
							if(isset($client))
								{
									foreach($client as $value)
									{

										echo '<tr>';
							      echo '  <td>'.$value['last_name'].'</td>';
							      echo '  <td>'.$value['first_name'].'</td>';
							      echo '  <td>'.$value['email'].'</td>';
							      echo '  <td>'.$value['phone'].'</td>';
							      echo '  <td>'.$value['user_extra_info_birthday'].'</td>';
							      echo '  <td>'.$value['user_extra_info_address'].'</td>';
										echo '	<td>'.($value['active'] ? 'Active': 'Inactive').'</td>';
										echo '	<td><a href="userStatus/'.$value['id'].'">'.($value['active'] ? 'Disable': 'Enable').'</td>';
							      echo '</tr>';
									}
								}
							?>
				    </tbody>
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

      function addService()
      {
        var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/serviceAdd/";

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
              alert('Service added.');
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
