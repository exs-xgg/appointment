<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
					parent::__construct();

					$this->load->model('crud_model');
					$this->load->model('fetch_model');
					$this->load->helper('url_helper');
					$this->load->database();
	}

	public function index()
	{
		$this->load->view('template/header.php');
		$this->load->view('contact.php');
		$this->load->view('template/footer.php');
	}

	public function sendMessage()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			$data['error'] = validation_errors();

			$this->load->view('template/header.php');
			$this->load->view('contact.php', $data);
			$this->load->view('template/footer.php');
		}
		else
		{
			$email = $this->input->post('email');
			$name = $this->input->post('name');
			$message = $this->input->post('message');

			if($this->email($email, $name, $message))
			{
				$data['status'] = "Message sent.";
			}
			else
			{
				$data['status'] =  "Message not sent.";
			}
			$this->load->view('template/header.php');
			$this->load->view('contact.php', $data);
			$this->load->view('template/footer.php');
		}
	}

	function email($email, $name, $message)
	{
		$config = array(
		    'protocol'  => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'dummyemail12313123@gmail.com',
		    'smtp_pass' => '!@#$%^&*()',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = "Name: ".$name."<br>";
		$htmlContent .=  "Email: ".$email."<br>";
		$htmlContent .=  "Message: ".$message."<br>";
		/*$htmlContent .= '<br>Thank you.</p>';
		$htmlContent .= '<p><strong>Dra. Sico Dental Clinic</p><strong>';*/

		$this->email->to('jcmangana@theorchardgolf.com'); //change to company email
		$this->email->from($email, $name);
		$this->email->subject('New Message from '.$name);
		$this->email->message($htmlContent);

		//Send email

		if($this->email->send())
		{
			return true;
		}
		else
		{
			return false;
		}

	}


}
