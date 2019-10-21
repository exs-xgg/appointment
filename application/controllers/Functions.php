<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//date_default_timezone_set('Asia/Manila');

class Functions extends CI_Controller {

  public function __construct()
  {
          parent::__construct();

          $this->load->model('crud_model');
					$this->load->model('fetch_model');
          $this->load->helper('url_helper');
          $this->load->database();
  }

  public function serviceAdd()
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
    {
      $this->crud_model->database=$this->load->database();
      $this->form_validation->set_rules('serviceName', 'Service Name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('serviceDesc', 'Service Description', 'trim|required|xss_clean');
      $this->form_validation->set_rules('serviceDuration', 'Service Duration', 'trim|required|xss_clean');

      if ($this->form_validation->run() == FALSE)
  		{
  			echo validation_errors();
  		}
  		else
  		{
  			$data = array(
  		     'services_name' => $this->input->post('serviceName'),
  		     'services_description' => $this->input->post('serviceDesc'),
  		     'services_duration' => $this->input->post('serviceDuration')
  			);

  			$insert = $this->crud_model->servicesAdd($data);
  			if($insert)
  			{
  				$data['success'] = true;

  				echo json_encode(array("status" => TRUE));
  			}
      }
    }
  }

  public function serviceEdit($id)
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
    {
  		$this->crud_model->database=$this->load->database();
      $this->form_validation->set_rules('serviceNameEdit', 'Service Name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('serviceDescEdit', 'Service Description', 'trim|required|xss_clean');
      //$this->form_validation->set_rules('serviceDurationEdit', 'Service Duration', 'trim|required|xss_clean');

  		if ($this->form_validation->run() == FALSE)
  		{
  			echo validation_errors();
  		}
  		else
  		{
  			$data = array(
  		     'services_name' => $this->input->post('serviceNameEdit'),
  		     'services_description' => $this->input->post('serviceDescEdit'),
  		     //'services_duration' => $this->input->post('serviceDurationEdit')
  			);
  			$update = $this->crud_model->servicesUpdate(array('services_id' => $id),	$data);
  			if($update)
  			{
  				$data['success'] = true;

  				echo json_encode(array("status" => TRUE));
  			}
  		}
    }
  }

  public function servicesGet($id)
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
    {
      $service = $this->fetch_model->getServicesInfo2($id);

      echo json_encode($service);
    }
  }

  public function confirmAppointment($id)
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
    {
      $this->crud_model->database=$this->load->database();
      $this->form_validation->set_rules('confirmAppointment', 'Confirm Appointment', 'trim|required|xss_clean');

  		if ($this->form_validation->run() == FALSE)
  		{
  			echo validation_errors();
  		}
  		else
  		{
  			$data = array(
  		     'appointment_confirmed' => $this->input->post('confirmAppointment')
  			);
  			$update = $this->crud_model->appointmentUpdate(array('appointment_id' => $id),	$data);
  			if($update)
  			{
  				$data['success'] = true;

  				echo json_encode(array("status" => TRUE));
  			}
  		}
    }
  }

  public function cancelAppointment($id)
  {
    if($this->ion_auth->logged_in() && (($this->ion_auth->in_group("admin") || ($this->ion_auth->in_group("client")))))
    {
      $this->crud_model->database=$this->load->database();
      $cancel = false;

      if($this->ion_auth->in_group("admin"))
      {
        $cancel = true;
      }
      else if($this->ion_auth->in_group("client"))
      {
        $appointment = $this->fetch_model->getAppointmentDetails($id);
        if($appointment[0]['client_id']==$this->ion_auth->user()->row()->id)
        {
          $cancel = true;
        }
      }

      if($cancel)
      {
        $data = array(
    	     'appointment_cancelled' => 1
    		);
    		$update = $this->crud_model->appointmentUpdate(array('appointment_id' => $id),	$data);
    		if($update)
    		{
    			$data['success'] = true;

          $info = $this->fetch_model->getClientNumber($id);
          $appointmentDetails = $this->fetch_model->getAppointmentDetails($id);

          if(!is_null($info))
          {

            $time = date('h:iA', strtotime($appointmentDetails[0]['time']));;
            $date = date('F d, Y', strtotime($appointmentDetails[0]['date']));

            $number = '0'.$info[0]['phone'];
            $message = "Your scheduled ".$appointmentDetails[0]['service']." on ".$date." at ".$time." has been cancelled.";
            $message .= "\r\n\r\n-Dra. Sico Dental Clinic";

            $this->sms($number, $message);
          }

    			echo json_encode(array("status" => TRUE));
    		}
      }
    }
  }

  public function showUpAppointment($id)
  {
    if($this->ion_auth->logged_in() && $this->ion_auth->in_group("admin"))
    {
      $this->crud_model->database=$this->load->database();

  		$data = array(
  	     'appointment_show_up' => 1
  		);

  		$update = $this->crud_model->appointmentUpdate(array('appointment_id' => $id),	$data);
  		if($update)
  		{
  			$data['success'] = true;

  			echo json_encode(array("status" => TRUE));
  		}
    }
  }

  function sms($phone, $content)
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin") || $this->ion_auth->in_group("client")))
    {
      $number = $phone;
      $message = $content;

      $url = 'https://api.semaphore.co/api/v4/messages';
      $data = array('apikey' => '5cf44351b6de92f7bfeeea5e4095117b', 'number' => $number, 'message' => $message);

      // use key 'http' even if you send the request to https://...
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'method'  => 'POST',
              'content' => http_build_query($data)
          )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
      if ($result === FALSE) { /* Handle error */ }

      //echo($result);
    }
  }

  public function sendSMSNotifyClientsList()
  {
    if($this->ion_auth->logged_in() && $this->ion_auth->in_group("admin"))
    {
      $data['list'] = $this->fetch_model->getSMSNotifyClientsList();

      foreach ($data['list'] as $value)
      {
        $date = date('F d, Y', strtotime($value['appointment_date']));
        $time = date('h:iA', strtotime($value['appointment_start_time']));;

        $message = "You have a scheduled ".$value['services_name']." by ".$value['first_name']." ".$value['last_name']." on ".$date." at ".$time.". Thank you.\r\n\r\n-Dra. Sico Dental Clinic";
        $number =  $value['phone'];

        $this->sms($number, $message);

        $data = array(
  		     'appointment_sms_notification' => 1
  			);
  			$update = $this->crud_model->appointmentUpdate(array('appointment_id' => $value['appointment_id']),	$data);

      }

      echo '<script>';
      echo '  alert("Sending SMS notification now started.");';
      echo '  var url = window.location.href;';
      echo '  var arr = url.split("/");';
      echo '  url = window.location.protocol + "//" + window.location.hostname + "/" + arr[3] + "/index.php/dashboard/";';
      echo '  window.location.replace(url);';
      echo '</script>';
    }
  }
  public function isBlocked(){
    $isBlocked = FALSE;
    $res_date = "";
    $dateToCheck = $_GET['date'];
    $query = $this->db->get_where('blocked_date',array('block' => $dateToCheck));
    $res_date = $this->db->get_where('appointment',array('appointment_date' => $dateToCheck));
    $isBlocked =  ($query->num_rows() > 0) ? true : false;
    echo json_encode(array("isBlocked" => $isBlocked, "res_date" => ( $res_date->result_array()) ));
  }
  public function getAppointmentList()
  {
    if($this->ion_auth->logged_in())
    {
      $start = null;
      $end = null;
      $group = null;
      $id=null;

      if($this->ion_auth->in_group("admin"))
      {
        $group = "admin";
      }
      else if($this->ion_auth->in_group("dentist"))
      {
        $group = "dentist";
      }
      else {
        $group= "client";
      }

      $id = $this->ion_auth->user()->row()->id;


      if(isset($_GET['start']))
      {
        $start = date('Y-m-d', strtotime($_GET['start']));
      }
      if(isset($_GET['end']))
      {
        $end = date('Y-m-d', strtotime($_GET['end']));
      }


      $data['list'] = $this->fetch_model->getAppointmentList($start, $end, $group, $id);

      echo json_encode($data['list']);
    }
  }

  public function checkSchedAvailability()
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin") || $this->ion_auth->in_group("client")))
    {
      if(isset($_GET['date']) && isset($_GET['time']))
      {
        $check = $this->fetch_model->getAppointmentAvailability($_GET['date'], $_GET['service'], $_GET['provider'], $_GET['time']);
        $response = array('code' => $check[0], 'response' => $check[1] );

        echo json_encode($response);
      }
    }
  }

  public function checkNumber($value)
	{
		if(is_numeric($value))
		{
			return true;
		}
		return false;
	}

  public function addAppointment()
  {
    if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin") || $this->ion_auth->in_group("client")))
    {
      if(isset($_GET['date']) && isset($_GET['service']) && isset($_GET['provider']) && isset($_GET['time']) && isset($_GET['client']) && isset($_GET['notes']))
      {
        $this->crud_model->database=$this->load->database();

        $_POST['date'] = !is_null($_GET['date']) ? $_GET['date'] : null;
        $_POST['service'] = !is_null($_GET['service']) ? $_GET['service'] : null;
        $_POST['provider'] = !is_null($_GET['provider']) ? $_GET['provider'] : null;
        $_POST['time'] = !is_null($_GET['time']) ? $_GET['time'] : null;
        $_POST['client'] = !is_null($_GET['client']) ? $_GET['client'] : null;
        $_POST['notes'] = !is_null($_GET['notes']) ? $_GET['notes'] : null;

        /*
    		$this->form_validation->set_rules('date', 'Schedule Date', 'trim|required');
    		$this->form_validation->set_rules('service', 'Service', 'trim|required');
    		$this->form_validation->set_rules('provider', 'Provider', 'trim|required');
    		$this->form_validation->set_rules('time', 'Schedule Time', 'required');
    		$this->form_validation->set_rules('client', 'Client', 'trim|required');*/
        $serviceDuration = $this->fetch_model->getServicesInfo($_POST['service']);
        $duration = $serviceDuration[0]['services_duration'];

        $unix_timestamp = substr($this->input->post('time'), 0, strlen($this->input->post('time'))-3);
        $datetime = new DateTime("@$unix_timestamp");
        $datetime = $datetime->format('H:i');
        $tz = new DateTimeZone('Asia/Manila');
        $date = new DateTime($datetime);
        //$date->setTimezone($tz);

        $datetime2 = $datetime;
        $datetime2 = date('H:i',strtotime('+'.$duration.' minutes',strtotime($datetime2)));
        $date2 = new DateTime($datetime2);
        $date2->setTimezone($tz);
        //$date_end = date('H:i', $date_end);

  			$data = array(
  			'appointment_date' => $this->input->post('date'),
  			'appointment_start_time' => $date->format('H:i'),
  			'appointment_end_time' => $date2->format('H:i'),
  			'appointment_client_id' => $this->input->post('client'),
  			'appointment_dentist_id' => $this->input->post('provider'),
  			'appointment_service_id' => $this->input->post('service'),
  			'appointment_notes' => $this->input->post('notes'),
  			'appointment_timestamp' => date('Y-m-d H:i:s')
        );
        

  			$insert = $this->crud_model->appointmentAdd($data);

  			if($insert)
  			{
  				$data['success'] = true;

          $id = $insert;
          $info = $this->fetch_model->getClientNumber($id);
          $appointmentDetails = $this->fetch_model->getAppointmentDetails($id);

          if(!is_null($info))
          {

            $time = date('h:iA', strtotime($appointmentDetails[0]['time']));;
            $date = date('F d, Y', strtotime($appointmentDetails[0]['date']));

            $number = '0'.$info[0]['phone'];
            $message = "Your scheduled ".$appointmentDetails[0]['service']." on ".$date." at ".$time." has been booked.";
            $message .= "\r\n\r\n-Dra. Sico Dental Clinic";

            $this->sms($number, $message);

          }
          //

  				echo json_encode(array("status" => TRUE, "id" => $insert));
  			}

      }
    }
  }
}
