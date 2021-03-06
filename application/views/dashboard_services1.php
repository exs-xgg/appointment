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
				        <th>Service Name</th>
				        <th>Description</th>
				        <th>Duration (Minutes)</th>
								<th>Action</th>
				      </tr>
				    </thead>
				    <tbody>
							<?php
							if(isset($services))
								{
									foreach($services as $value)
									{
										echo '<tr>';
							      echo '  <td>'.$value['services_name'].'</td>';
							      echo '  <td>'.$value['services_description'].'</td>';
							      echo '  <td>'.$value['services_duration'].'</td>';
										echo '	<td><input type="button" value="Edit" onclick="openService('.$value['services_id'].');"></td>';
							      echo '</tr>';
									}
								}
							?>
							<tr>
								<form id="formServiceAdd">
									<td><input type="text" placeholder="Enter Service Name" id="serviceName" name="serviceName" class="input-xlarge"></td>
									<td><input type="text" placeholder="Enter Description" id="serviceDesc" name="serviceDesc" class="input-xlarge"></td>
									<td>
										<select id="serviceDuration" name="serviceDuration"  class="form-control">
											<option>30</option>
											<option>60</option>
											<option>90</option>
											<option>120</option>
										</select>
									</td>
									<td><input tabindex="9" class="btn btn-inverse large" type="button" value="Add New Service" onclick="addService();"></td>
								</form>
							</tr>
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

				<div id="eventContent" title="Event Details" style="display:none;">
						<form id="formServiceEdit" name="formServiceEdit">
							<input type="hidden" id="serviceIDEdit" name="serviceIDEdit" value="">
							Service Name: <input type="text" placeholder="Enter Name" id="serviceNameEdit" name="serviceNameEdit" class="input-xlarge"><br>
							Description: <input type="text" placeholder="Enter Description" id="serviceDescEdit" name="serviceDescEdit" class="input-xlarge"><br>
							Duration: <br>
							<select id="serviceDurationEdit" name="serviceDurationEdit"  class="form-control" disabled>
								<option>30</option>
								<option>60</option>
								<option>90</option>
								<option>120</option>
							</select>
							<hr>
							<p>
								<?php
									if($this->ion_auth->in_group("admin"))
									{
										echo '<input tabindex="9" class="btn btn-inverse large" type="button" value="Save" onclick="editService();">';
									}
								?>

							</p>
						</form>
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
              toastr.success('Service added.');
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

			function openService(id)
			{
				var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/servicesGet/" + id;

        $('#wait').show();
        $.ajax({
					type: "GET",
          url : url,
					dataType: "JSON",
          success: function(data)
          {
						$('#serviceNameEdit').val(data[0].Name);
						$("#serviceDescEdit").val(data[0].Desc);
						$("#serviceDurationEdit").val(data[0].Duration);
						$("#serviceIDEdit").val(data[0].ID);
						$("#eventContent").dialog({ modal: true, title: "Edit Service", width:350});
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

			function editService()
			{
				var id = $("#serviceIDEdit").val();
				var url = window.location.href;
				var arr = url.split("/");
				url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/serviceEdit/" + id;

				var form = $("#formServiceEdit");

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
							toastr.success('Service edited.');
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
