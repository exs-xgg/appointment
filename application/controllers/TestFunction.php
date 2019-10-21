<?php

//////////////////////////////////////////////////////////////
// This page is for debugginf purposes.                     //
// Not intended to run or exists in production.             //
//////////////////////////////////////////////////////////////

defined('BASEPATH') OR exit('No direct script access allowed');

class TestFunction extends CI_Controller {

  public function __construct()
  {
          parent::__construct();
          $this->load->model('fetch_model');
          $this->load->helper('url_helper');
          $this->load->database();
  }

  public function testCalendar()
  {
    $data['services'] = $this->fetch_model->getServicesList();
    $data['provider'] = $this->fetch_model->getProviderList();
    $data['client'] = $this->fetch_model->getClientList();

    $this->load->view('template/header.php');
    $this->load->view('calendar.php',  $data);
		$this->load->view('template/footer.php');
  }


  public function testSMS()
  {
    $number = '09955593486';
    $message = 'Test function sms sending.';

    $url = 'http://localhost/appointment/index.php/functions/sms';
    $data = array('number' => $number, 'message' => $message);

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

    echo $result;
  }

  public function testAddAppointment()
  {
    $url = 'http://localhost/appointment/index.php/functions/addappointment';
    $data = array(
                  'appointmentDate' => '2019-06-23',
                  'appointmentTimeStart' => '08:00:00',
                  'appointmentTimeEnd' => '08:30:00',
                  'appointmentClientID' => 2,
                  'appointmentDentistID' => 1,
                  'appointmentServiceID' => 2,
                  'appointmentNotes' => 'Allergic to Anesthesia.'
                );

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

    var_dump($result);
  }

}
