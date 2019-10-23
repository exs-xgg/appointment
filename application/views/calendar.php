
    <style>
    </style>

    <div class="loader-inner line-scale-pulse-out" id="wait">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>

    <div id='calendar'></div>

    <div id="eventContent" title="Event Details" style="display:none;">
        Description: <strong><span id="description"></span></strong><br><br>
        Start: <strong><span id="startTime"></span></strong><br>
        End: <strong><span id="endTime"></span></strong><br>
        <p id="eventInfo"></p>
        <p>
          <?php
            if($this->ion_auth->in_group("admin"))
            {
              echo '<strong><a class="btn btn-link" id="eventLink1" onclick="">Appointment Show Up</a></strong>';
              echo '<br>';
              echo '<strong><a class ="btn btn-link" id="eventLink2" onclick="">Cancel Appointment</a></strong>';
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


        echo '  <p><strong>Date:</strong> <input class="form-control" type="text" id="schedDate" name="schedDate" ></p>';
        echo '  <p><strong>Time:</strong> <input class="form-control" type="text" id="schedDate2" name="schedDate2" ></p>';
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

        echo '  <button type="button" class="btn btn-info" onclick="bookSchedule();">Book Appointment</button>';
        echo '  <br>';
        echo '  <br>';
        echo '  <div id="status" class="alert alert-danger" role="alert" style="display:none;">';
        echo '    Registration info here.';
        echo '  </div>';
        echo '</div>';
      }
    ?>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script>

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
              toastr.error('There was an error while fetching events!');
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
                toastr.success('Appointment cancelled.');

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
              toastr.success('Show up status changed.');

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
        if(day == "Sunday")
        {
          	openingTimeString = "8:00am";
			closingTimeString = "12:00pm";
        }
        else
        {
          	openingTimeString = "8:00am";
			closingTimeString = "5:00pm";
        }
        
        var closingTime = moment(closingTimeString, 'h:mma');
        var openingTime = moment(openingTimeString, 'h:mma');
        var closingTimeCheck = moment(time, 'h:mma').isAfter(closingTime);
        var openingTimeCheck = moment(time, 'h:mma').isBefore(openingTime);

        //
        time = moment($("#schedDate2").data('daterangepicker').startDate).valueOf();

        if(openingTimeCheck || closingTimeCheck)
        {
          $("#status").attr("class", "alert alert-danger");
          $('#status').text('Clinic is still closed.');
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
              toastr.error("Appointment not added.");
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
