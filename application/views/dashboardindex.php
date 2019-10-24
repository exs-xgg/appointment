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
					<a href="<?php echo base_url('/index.php/dashboard'); ?>" class="logo pull-left"><img src="<?php echo base_url('asset/include/themes/images/logo.png'); ?>" class="site_logo" alt=""></a>
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
					<?php
					if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
					{
						echo '<div>';
            echo '<button class="btn btn-primary" onclick="ajaxSendSMS()">Send SMS Notification</button>';
						echo '</div>';
					}
          ?>

          <script>
function ajaxSendSMS(){
$.get({
  url: "<?php echo base_url('/index.php/functions/sendSMSNotifyClientsList'); ?>"
});
toastr.success("SMS Now Queued for Sending!");
}
</script>
					<div id='calendar'></div>
				</div>


				<div class="loader-inner line-scale-pulse-out" id="wait">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>

				<div id="eventContent" title="Event Details" style="display:none;">
						Description: <strong><span id="description"></span></strong><br><br>
						Start: <strong><span id="startTime"></span></strong><br>
						End: <strong><span id="endTime"></span></strong><br>
						<p id="eventInfo"></p>
						<p>
							<?php
								if($this->ion_auth->in_group("admin"))
								{
                  echo '<button class="btn btn-link" id="eventLink1" style="width:90%;background-color:#e6e6e6;border-radius:10px;border:1px solid black;color:black;">Appointment Showed Up</button>';
                  echo '<br>';
                  echo '<br>';
                  echo '<button class ="btn btn-link" id="eventLink2" style="width:90%;background-color:#e6e6e6;border-radius:10px;border:1px solid black;color:black;">Cancel Appointment</button>';
								}
							?>

						</p>
				</div>

				<?php
					if( ( $this->ion_auth->in_group("admin") || $this->ion_auth->in_group("client") ) )
					{
						echo '<div id="eventAdd" title="Add New Schedule" style="display:none;">';
						echo '';

						if($this->ion_auth->in_group("admin"))
						{
							echo '  <p>';
							echo '    <strong>Client:</strong>';
							echo '    <select id="schedClient" class="form-control">';
							if(isset($client))
							{
								foreach($client as $value)
								{
									echo '<option value='.$value['id'].'>';
									echo $value['last_name'].', '.$value['first_name'];
									echo '</option>';
								}
							}
						}

						echo '    </select>';
						echo '  </p>';


            echo '  <p><strong>Date:</strong> <input class="form-control" type="text" id="schedDate" name="schedDate" onchange="seeCurApt()"></p>';
            
						echo '  <div id="status" class="alert alert-danger" role="alert" style="display:none;">';
						echo '    Registration info here.';
						echo '  </div>';
            ?>
            <hr>
            <b>Current appointments for selected date:</b>
            <table class="table">
              <thead>
                <tr><th>Start Time</th><th>End Time</th></tr>  
            </thead>
            <tbody id="reservedDates">
            </table>
            <hr>
            <?php
						echo '  <p><strong>Time:</strong> <input class="form-control" type="text" id="schedDate2" name="schedDate2" readonly></p>';
						echo '  <p>';
						echo '    <strong>Service:</strong>';
						echo '    <select id="schedServices" class="form-control">';

									if(isset($services))
									{
										foreach($services as $value)
										{
											echo '<option value='.$value['services_id'].'>';
											echo $value['services_name'].' | Est. duration: '.$value['services_duration'].' mins.';
											echo '</option>';
										}
									}

						echo '    </select>';
						echo '  </p>';
						echo '  <p>';
						echo '    <strong>Dentist:</strong>';
						echo '    <select id="schedProvider" class="form-control">';

									if(isset($provider))
									{
										foreach($provider as $value)
										{
											echo '<option value='.$value['id'].'>';
											echo $value['last_name'].', '.$value['first_name'];
											echo '</option>';
										}
									}

						echo '    </select>';
						echo '  </p>';
						echo '  <p>';
						echo '    <strong>Notes:</strong>';
						echo '    <textarea class="form-control" id="schedNotes" rows="3"></textarea>';
						echo '  </p>';

						echo '  <button id="btnAptAdd" type="button" class="btn btn-info" onclick="bookSchedule();">Book Appointment</button>';
						echo '  <br>';
						echo '  <br>';
						echo '  <div id="status" class="alert alert-danger" role="alert" style="display:none;">';
						echo '    Registration info here.';
						echo '  </div>';
						echo '</div>';
					}
				?>

				<!-- -->
			</section>
      <section>
      <div class="well">
          <div class="well-body">
            <div class="container">
            <div class="">
              <div style="max-width: 45%; float: left; padding: 20px">
                <h4>Blocked Dates</h4>
                <label for="blkdate">Insert Date to Block</label>
                <input type="date" name="block_date" id="blkdate"><br>
                <button class="btn btn-primary" onclick="addBreak()">Block Date</button>
              </div>
              <div style="max-width: 45%; float: left; padding: 20px">
                <h4>Blocked Dates List</h4>
                <table id="blktbl" class="table"  style="min-width: 100%; float: left">
                  <thead>
                    <tr><th>Date</th><th>Action</th><tr>
                  </thead>
                  <tbody>
                    <tr><td>Loading</td><td></td></tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      <script>

      fetchBreaks();

      var url = window.location.href;
        var arr = url.split("/");
      function fetchBreaks(){
        
      var url = window.location.href;
        var arr = url.split("/");
        $.get({
          url: window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/whatsMyBreak",
            success: function(data){
              $("#blktbl tbody").empty();
              data = JSON.parse(data);
              data.forEach(function(fd) {
                $("#blktbl tbody").append('<tr><td>' + moment(fd.block).format("MM/DD/YYYY") + '</td><td class="badge badge-warning" onclick="delBreak(' + fd.id + ')">Delete</td></tr>');
              });
            }
        });
      }
      function addBreak(){
        
      var url = window.location.href;
        var arr = url.split("/");
        $.get({
          url: window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/gimmeAbreak?date=" + $("#blkdate").val(),
          success: function(data){
            toastr.success("Added Blocked Date");
            
        fetchBreaks();

          }
        });

      }
      function delBreak(e){
        
      var url = window.location.href;
        var arr = url.split("/");
        $.get({
          url: window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/deleteMyBreak?id=" + e,
          success: function(data){
            toastr.success("Deleted Blocked Date");

            fetchBreaks();
          }
        });
      }
     
      </script>
      </section>
			<section id="footer-bar">
			</section>
			<section id="copyright">
				<span>Copyright 2019 All right reserved.</span>
			</section>
		</div>
<!-- 
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script>
      function seeCurApt(){
        $("#reservedDates").empty();
        var url = window.location.href;
        var arr = url.split("/");
        $("#status").css({"display":"none"});
        $("#btnAptAdd").removeAttr("disabled");
        
        $("#btnAptAdd").attr("class","btn btn-info");
        var dateToCheck = (moment($("#schedDate").val().replace(",","")).format("YYYY-MM-DD"));
        //FETCH Blocked SCHEDS
        $.get({
          url: window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/isBlocked?date=" + dateToCheck,
          success: function(data){
            data = JSON.parse(data);
            if(data.isBlocked){
              $("#btnAptAdd").attr("disabled","true");
              $("#btnAptAdd").attr("class","btn btn-danger");
              $("#status").attr("class", "alert alert-danger");
              $('#status').text("Dentist is not available on selected date. Please try other dates.");
              $("#status").css({"display":"block"});
              toastr.warning("Dentist is not available on selected date. Please try other dates.");
            }
            if(data.res_date){


              data.res_date.forEach(function(fd) {
                $("#reservedDates").append("<tr><td>" + moment(fd.appointment_start_time,"HH:mm").format('hh:mm A') + "</td><td>" + moment(fd.appointment_end_time,"HH:mm").format('hh:mm A') + "</td></tr>");
            });
              
            }else{
              $("#reservedDates").append("<tr><td>No Appointments</td><td></td></tr>");
            }
          }
          }
        );
       
        
      }
      var calendar = null;
      document.addEventListener('DOMContentLoaded', function() {
        var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/getAppointmentList/";

        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
          defaultView: 'dayGridMonth',
          selectable: true,
          header: {
                    left: 'prev,next addEventButton',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                  },
          eventTextColor: 'white',
          eventRender: function(info) {
            var tooltip = new Tooltip(info.el, {
              title: info.event.extendedProps.description,
              placement: 'top',
              trigger: 'hover',
              container: 'body'
            });
          },
          eventSources: [
          {
            url: url,
            extraParams: {
            },
            failure: function() {
              alert('there was an error while fetching events!');
            }
          }],
          slotDuration: '00:05:00',
          eventLimit: true,
          eventClick: function(info, element){
            var eventObj = info.event;
            url3 = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/showUpAppointment/";

            $("#description").html(eventObj.extendedProps.description);
            $("#startTime").html(moment(eventObj.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(eventObj.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(eventObj.description);
            $("#eventLink1").attr('onclick', 'showUpAppointment('+eventObj.id+')');
            $("#eventLink2").attr('onclick', 'cancelAppointment('+eventObj.id+')');
            $("#eventContent").dialog({ modal: true, title: eventObj.title, width:350});
          },
          customButtons: {
            <?php
              if( ( $this->ion_auth->in_group("admin") || $this->ion_auth->in_group("client") ) )
              {
                echo 'addEventButton: {';
                echo '  text: \'New Appointment\',';
                echo '  click: function() {';
                echo '    $("#eventAdd").dialog({ modal: true, title: \'Add New Schedule\', width:350});';
                echo '  }';
                echo '}';
              }
            ?>
          },
          loading: function( isLoading, view ) {
            if(isLoading)
            {
              $('#wait').show();
            }
            else
            {
              $('#wait').hide();
            }
          }
        });

        calendar.render();
      });

      function cancelAppointment(id)
      {
        if (confirm('Are you sure you want to cancel this appointment?'))
        {
          var url = window.location.href;
          var arr = url.split("/");
          url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/cancelAppointment/" + id;

          $('#wait').show();
          $.ajax({
            url : url,
            dataType: "JSON",
            success: function(data)
            {
              if(data.status)
              {
                alert('Appointment cancelled.');

                $('#eventContent').dialog( "close" );

                calendar.refetchEvents();
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
      }

      function showUpAppointment(id)
      {
        var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/showUpAppointment/" + id;

        $('#wait').show();
        $.ajax({
          url : url,
          dataType: "JSON",
          success: function(data)
          {
            if(data.status)
            {
              alert('Show up status changed.');

              $('#eventContent').dialog( "close" );

              calendar.refetchEvents();
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              document.getElementById("message").innerHTML = jqXHR.responseText;
          },
          complete: function(){
            $('#wait').hide();
          }
        });
      }

      function bookSchedule()
      {
        $("#status").css({"display":"none"});
        $("#confirmButton").css({"display":"none"});

        var date= $("#schedDate").data('daterangepicker').startDate.format('YYYY-MM-DD');
        var time=$("#schedDate2").data('daterangepicker').startDate.format('HH:mm:ss');

        var day = $("#schedDate").data('daterangepicker').startDate.format('dddd');

        var openingTimeString ="";
		var closingTime = moment('5:00pm', 'h:mma');

				var breakStart = "";
				var breakEnd = "";

        if(day == "Sunday")
        {
          openingTimeString = "8:00am";
			closingTime = moment('11:59am', 'h:mma');
        }
        else
        {
          openingTimeString = "8:30am";

					breakStart = moment("11:59am", 'h:mma');
					breakEnd = moment("12:59pm", 'h:mma');
        }

        var openingTime = moment(openingTimeString, 'h:mma');
        var closingTimeCheck = moment(time, 'h:mma').isAfter(closingTime);
        var openingTimeCheck = moment(time, 'h:mma').isBefore(openingTime);

				var breakStartCheck = moment(time, 'h:mma').isAfter(breakStart);
        var breakEndCheck = moment(time, 'h:mma').isBefore(breakEnd);
				var time3 = moment(time, 'h:mma');

        //
        time = moment($("#schedDate2").data('daterangepicker').startDate).add(8, 'hours').valueOf();
				time2 = moment($("#schedDate2").data('daterangepicker').startDate).valueOf();

        if(openingTimeCheck || closingTimeCheck)
        {
          $("#status").attr("class", "alert alert-danger");
          $('#status').text('Clinic is still closed.');
          $("#status").css({"display":"block"});
        }
				/*else if(breakStartCheck && breakEndCheck)
				{*/
				//else if(time3.isBetween(breakStart, breakEnd))
				else if(breakStartCheck && breakEndCheck)
				{
          $("#status").attr("class", "alert alert-danger");
          $('#status').text('Doctor is in break time.');
          $("#status").css({"display":"block"});
				}
        else
        {
          var url = window.location.href;
          var arr = url.split("/");
          url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/checkSchedAvailability/";

          $('#wait').show();
          $.ajax({
            url : url,
            type : "GET",
            dataType: "JSON",
            data: {
              date: date,
              service: $('#schedServices').val(),
              provider: $('#schedProvider').val(),
              time: time2,
              notes: $('#schedNotes').val(),

              <?php
                if($this->ion_auth->in_group("admin"))
                {
                  echo 'client: $(\'#schedClient\').val()';
                }
                else if($this->ion_auth->in_group("client"))
                {
                  echo 'client: '.$this->ion_auth->user()->row()->id;
                }
              ?>
            },
            success: function(data)
            {
              if(data.code == 1)
              {
                confirmBookSchedule(date, time);
              }
              else
              {
                $("#status").attr("class", "alert alert-danger");
                $('#status').text(data.response);
                $("#status").css({"display":"block"});
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              console.log(jqXHR.responseText);
            },
            complete: function(){
              $('#wait').hide();
            }
          });
        }
      }

      function confirmBookSchedule(date, time)
      {

        var url = window.location.href;
        var arr = url.split("/");
        url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/functions/addAppointment/";

        $('#wait').show();
        $.ajax({
          url : url,
          type : "GET",
          dataType: "JSON",
          data: {
            date: date,
            service: $('#schedServices').val(),
            provider: $('#schedProvider').val(),
            time: time,
            notes: $('#schedNotes').val(),
            <?php
              if($this->ion_auth->in_group("admin"))
              {
                echo 'client: $(\'#schedClient\').val()';
              }
              else if($this->ion_auth->in_group("client"))
              {
                echo 'client: '.$this->ion_auth->user()->row()->id;
              }
            ?>
          },
          success: function(data)
          {
            if(data.status)
            {
              calendar.refetchEvents();

              toastr.success("Appointment added.");
              $('#eventAdd').dialog( "close" );
            }
            else
            {
              toastr.danger(data.message);
              $('#eventAdd').dialog( "close" );
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            console.log(jqXHR.responseText);
          },
          complete: function(){
            $('#wait').hide();
          }
        });
      }

      $(function() {
        var date = new Date();
        date.setDate(date.getDate() + 1);
        //date.setDate(date.getDate());

        $('input[name="schedDate"]').daterangepicker({
          minDate:date,
          singleDatePicker: true,
          startDate: moment().add(1,'days'),
          //startDate: moment(),
          locale: {
            format: 'MMMM DD, YYYY'
          },
          opens: "center"
        });

        if(moment().minute()> 30)
        {
          var myTime = moment().minute(30).second(0);
        }
        else
        {
          var myTime = moment().minute(0).second(0);
        }

        $('input[name="schedDate2"]').daterangepicker({
          singleDatePicker: true,
          timePicker: true,
          timePickerIncrement: 30,
          startDate: myTime,
          locale: {
            format: 'hh:mm A'
          },
          opens: "center"
        }).on('show.daterangepicker', function (ev, picker) {
            picker.container.find(".calendar-table").hide();
        });
      });
    </script>
