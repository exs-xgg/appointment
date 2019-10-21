<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//date_default_timezone_set('Asia/Manila');

class Dashboard extends CI_Controller {


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
    if($this->ion_auth->logged_in())
    {
			$data['services'] = $this->fetch_model->getServicesList();
	    $data['provider'] = $this->fetch_model->getProviderList();
	    $data['client'] = $this->fetch_model->getClientList();

      if (($this->ion_auth->in_group("admin")))
      {
  			//echo 'admin';
      }
      else if(($this->ion_auth->in_group("client") || $this->ion_auth->in_group("dentist")))
      {
        //echo 'not admin';
      }
			$this->load->view('template/header_dashboard.php');
			$this->load->view('dashboardindex.php', $data);
			$this->load->view('template/footer_dashboard.php');
    }
    else
    {
      //$this->load->view('login.php');
			$this->load->view('template/header.php');
      $this->load->view('loginnew.php');
			$this->load->view('template/footer.php');
    }
	}

	public function services()
	{
		if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
    {
			$data['services'] = $this->fetch_model->getServicesList();
	    $data['provider'] = $this->fetch_model->getProviderList();
	    $data['client'] = $this->fetch_model->getClientList();

			$this->load->view('template/header_dashboard.php');
			$this->load->view('dashboard_services.php', $data);
			$this->load->view('template/footer_dashboard.php');
    }
    else
    {
      //$this->load->view('login.php');
			redirect('/dashboard', 'refresh');
    }
	}

	public function users()
	{
		if($this->ion_auth->logged_in() && ($this->ion_auth->in_group("admin")))
		{
			$data['services'] = $this->fetch_model->getServicesList();
			$data['provider'] = $this->fetch_model->getProviderList();
			$data['client'] = $this->fetch_model->getClientList2();

			$this->load->view('template/header_dashboard.php');
			$this->load->view('dashboard_users.php', $data);
			$this->load->view('template/footer_dashboard.php');
		}
		else
		{
			//$this->load->view('login.php');
			redirect('/dashboard', 'refresh');
		}
	}

	public function profile()
	{
		if($this->ion_auth->logged_in())
		{
			$data['services'] = $this->fetch_model->getServicesList();
			$data['provider'] = $this->fetch_model->getProviderList();
			$data['client'] = $this->fetch_model->getClientList2();
			$data['userDetails'] = $this->fetch_model->getClientList3($this->ion_auth->user()->row()->id);

			$this->load->view('template/header_dashboard.php');
			$this->load->view('dashboard_profile.php', $data);
			$this->load->view('template/footer_dashboard.php');
		}
		else
		{
			//$this->load->view('login.php');
			redirect('/dashboard', 'refresh');
		}
	}

	public function appointment()
	{
		if($this->ion_auth->logged_in() && $this->ion_auth->in_group("admin"))
		{
			$data['appointment'] = $this->fetch_model->getListAppointment();

			$this->load->view('template/header_dashboard.php');
			$this->load->view('dashboard_appointment.php', $data);
			$this->load->view('template/footer_dashboard.php');
		}
		else
		{
			redirect('/dashboard', 'refresh');
		}
	}

  public function login()
	{
		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page

				if($this->ion_auth->in_group("clients"))
				{
					redirect('/dashboard/logout', 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('/dashboard', 'refresh');
				}
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('dashboard/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			if($this->ion_auth->logged_in())
	    {
				redirect('/dashboard', 'refresh');
			}
			else
			{
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('template/header.php');
				$this->load->view('loginnew.php', $this->data);
				$this->load->view('template/footer.php');

					// code...
			}
		}
	}

	public function logout()
	{
		$this->ion_auth->logout();

		$header='location: '.base_url().'index.php/dashboard';
	  header($header);
		//redirect("admin", 'refresh');
	}

	public function register()
	{
		if (!$this->ion_auth->logged_in())
    {
			$this->load->view('template/header.php');
			$this->load->view('registernew.php');
			$this->load->view('template/footer.php');
		}
		else
		{
			redirect('/dashboard', 'refresh');
		}
	}

	public function registerProcess()
	{
		if (!$this->ion_auth->logged_in())
    {
			$this->form_validation->set_rules('registerFirstName', 'First Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('registerLastName', 'Last Name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('registerEmail', 'Email', 'trim|required|xss_clean|is_unique[users.email]|valid_email');
			$this->form_validation->set_rules('registerPhone', 'Phone', 'trim|required|xss_clean|is_unique[users.phone]');
			$this->form_validation->set_rules('registerPassword', 'Password', 'trim|required|xss_clean|min_length[8]|matches[registerReenter]');
			$this->form_validation->set_rules('registerReenter', 'Reenter Password', 'trim|required|xss_clean|min_length[8]');
			$this->form_validation->set_rules('registerAddress', 'Address', 'trim|required|xss_clean');
			$this->form_validation->set_rules('registerBirthday', 'Birthday', 'trim|required|xss_clean'); //todo

			if ($this->form_validation->run() == FALSE)
			{
				$this->data['error'] = validation_errors();
				//$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('template/header.php');
  			$this->load->view('registernew.php', $this->data);
  			$this->load->view('template/footer.php');
			}
			else
			{
				$username = str_replace(' ', '', $this->input->post('registerLastName').$this->input->post('registerFirstName'));
		    $password = $this->input->post('registerPassword');
		    $email = $this->input->post('registerEmail');
		    $additional_data = array(
		                'first_name' => $this->input->post('registerFirstName'),
		                'last_name' => $this->input->post('registerLastName'),
										'phone' => $this->input->post('registerPhone')
		                );
		    $group = array('2'); // Sets user to admin.

				$regID = $this->ion_auth->register($username, $password, $email, $additional_data, $group);
		    if($regID)
				{
					$data = array(
	  		     'user_extra_info_user_id' => $regID,
	  		     'user_extra_info_address' => $this->input->post('registerAddress'),
	  		     'user_extra_info_birthday' => $this->input->post('registerBirthday'),
	  			);
	  			$insert = $this->crud_model->registerUserExtraInfoAdd($data);//extra info add

					$confirmCode = sprintf("%06d", mt_rand(1, 999999));
					$data = array(
	  			'register_confirm_user_id' => $regID,
	  			'register_confirm_code' => $confirmCode,
	  			'register_confirm_email' => $email
	  			);
	  			$insert = $this->crud_model->registerConfirmAdd($data);

					$user = $this->ion_auth->user($regID)->row();

					//
					$number = '0'.$user->phone;;
          $message = "Your confirmation code is ".$confirmCode.".";
          $message .= "\r\n\r\n-Dra. Sico Dental Clinic";
          //$this->sms($number, $message);
					$this->email($confirmCode, $this->input->post('registerEmail'));
					//

					$data['status'] = true;
					$data['activation'] = 'Please confirm your account by entering your registered email address and the confirmation code sent to your email address.';

					$this->load->view('template/header.php');
	  			$this->load->view('registerverifynew.php', $data);
	  			$this->load->view('template/footer.php');
				}
				else
				{
					$data['status'] = false;

					$this->load->view('template/header.php');
	  			//$this->load->view('template/registrationsuccess.php', $data);
	  			$this->load->view('template/footer.php');
				}

			}
		}
		else
		{
			redirect('', 'refresh');
		}
	}

	public function registerConfirm()
	{
		if (!$this->ion_auth->logged_in())
    {

			$this->form_validation->set_rules('registerCode', 'Confirmation Code', 'trim|required|xss_clean');
			$this->form_validation->set_rules('registerEmail', 'Email', 'trim|required|xss_clean|valid_email');

			if ($this->form_validation->run() == FALSE)
			{
				$this->data['error'] = validation_errors();
				$data['activation'] = 'Please confirm your account by entering your registered email address and the confirmation code sent to your email address.';

				$this->load->view('template/header.php');
				$this->load->view('registerverifynew.php', $data);
				$this->load->view('template/footer.php');
			}
			else
			{
				$email = $this->input->post('registerEmail');
		    $code = $this->input->post('registerCode');

				$check = $this->fetch_model->getConfirmCode($email, $code);

				if($check)
				{
					$id = $check[0]['register_confirm_id'];
					$userid = $check[0]['register_confirm_user_id'];
					$this->crud_model->database=$this->load->database();

		  		$data = array(
		  	     'register_confirm_timestamp' => date('Y-m-d H:i:s')
		  		);

		  		$update = $this->crud_model->registerConfirmUpdate(array('register_confirm_id' => $id),	$data);

					if($update)
					{
						$activation = $this->ion_auth->activate($userid);

						if($activation)
						{
							$data['activation'] = 'Your account has been activated. Please login now.';

							$this->load->view('template/header.php');
							$this->load->view('loginnew.php', $data);
							$this->load->view('template/footer.php');

						}
					}
				}
				else
				{
					$data['activation'] = 'Invalid details provided.';

					$this->load->view('template/header.php');
					$this->load->view('registerverifynew.php', $data);
					$this->load->view('template/footer.php');
				}
			}
		}
		else
		{
			redirect('', 'refresh');
		}
	}

	public function userStatus($id)
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group("admin"))
    {
			if($this->ion_auth->user($id)->row()->active)
			{
				$this->ion_auth->deactivate($id);
			}
			else
			{
				$this->ion_auth->activate($id);
			}

			redirect('/dashboard/users', 'refresh');
		}
	}

	public function changePassword()
	{
		if ($this->ion_auth->logged_in())
		{
			//$this->form_validation->set_rules('old', 'Old Password', 'required');
			$this->form_validation->set_rules('oldPassword', 'Old Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('newPassword', 'New Password', 'required|min_length[8]|matches[newPasswordConfirm]');
			$this->form_validation->set_rules('newPasswordConfirm', 'Confirm Password', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				$data['error'] = validation_errors();

				$this->load->view('template/header.php');
				$this->load->view('dashboard_profile.php', $data);
				$this->load->view('template/footer.php');
			}
			else
			{
				$identity = $this->session->userdata('identity');

				$change = $this->ion_auth->change_password($identity, $this->input->post('oldPassword'), $this->input->post('newPasswordConfirm'));

				if ($change)
				{
					//if the password was successfully changed
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->logout();
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());

					$data['error'] = $this->ion_auth->errors();
					$data['userDetails'] = $this->fetch_model->getClientList3($this->ion_auth->user()->row()->id);

					//var_dump($this->ion_auth->errors());

					$this->load->view('template/header.php');
					$this->load->view('dashboard_profile.php', $data);
					$this->load->view('template/footer.php');
				}
			}
		}
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|xss_clean');

		if ($this->form_validation->run() === TRUE)
		{
			$email = $this->input->post('email');
			$oldPassHash = "$2y$10$7wXh9eKqdOjWNDg3cZzq1eF4WQEo1sm69wuqs6IOFeW4IpQPlR6u2";
			$newPass = $this->generateRandomString(10);

			$data['userInfo'] = $this->fetch_model->getInfo($email);

			if($data['userInfo'])
			{
				$id = $data['userInfo'][0]['id'];

				$data = array(
					 'password' => $oldPassHash
				);
				$update = $this->crud_model->userUpdate(array('id' => $id),	$data);

				$change = $this->ion_auth->change_password($email, "password", $newPass);

				$this->emailNewPass($newPass, $email);
				$data['passwordReset'] = "Password reset success. Please check your email for password reset.";
				$this->load->view('template/header.php');
	      $this->load->view('loginnew.php', $data);
				$this->load->view('template/footer.php');

			}
			else
			{
				$data['passwordReset'] = "Invalid email address.";
				$this->load->view('template/header.php');
	      $this->load->view('loginnew.php', $data);
				$this->load->view('template/footer.php');
			}
		}
	}

	function sms($phone, $content)
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

    // /echo($result);
  }

	function email($code, $email)
	{
		$config = array(
		    'protocol'  => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
				'smtp_user' => 'nimda0128@gmail.com',
		    'smtp_pass' => 'ytrewq321',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = '<p>Your confirmation code is '.$code;
		$htmlContent .= '<br>Thank you.</p>';
		$htmlContent .= '<p><strong>Dra. Sico Dental Clinic</p><strong>';

		$this->email->to($email);
		$this->email->from('lemuel@gmail.com','Dra. Sico Dental Clinic');
		$this->email->subject('Account Confirmation Code');
		$this->email->message($htmlContent);

		//Send email
		$this->email->send();
	}

	function generateRandomString($length = 10)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function emailNewPass($code, $email)
	{
		$config = array(
		    'protocol'  => 'smtp',
		    'smtp_host' => 'ssl://smtp.googlemail.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'nimda0128@gmail.com',
		    'smtp_pass' => 'ytrewq321',
		    'mailtype'  => 'html',
		    'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = '<p>Your new password is '.$code.' . Please change it after your login';
		$htmlContent .= '<br>Thank you.</p>';
		$htmlContent .= '<p><strong>Dra. Sico Dental Clinic</p><strong>';

		$this->email->to($email);
		$this->email->from('lemuel@gmail.com','Dra. Sico Dental Clinic');
		$this->email->subject('Password Reset');
		$this->email->message($htmlContent);

		//Send email
		$this->email->send();
	}


	public function changeProfile()
	{
		if ($this->ion_auth->logged_in())
		{
			//$this->form_validation->set_rules('old', 'Old Password', 'required');
			$this->form_validation->set_rules('registerFirstName', 'First Name', 'required');
			$this->form_validation->set_rules('registerLastName', 'Last Name', 'required');
			$this->form_validation->set_rules('registerEmail', 'Email Address', 'required');
			$this->form_validation->set_rules('registerPhone', 'Phone Number', 'required');
			$this->form_validation->set_rules('registerBirthday', 'Birth Day', 'required');
			$this->form_validation->set_rules('registerAddress', 'Address', 'required');

			if ($this->form_validation->run() == FALSE)
			{
				$data['services'] = $this->fetch_model->getServicesList();
				$data['provider'] = $this->fetch_model->getProviderList();
				$data['client'] = $this->fetch_model->getClientList2();
				$data['userDetails'] = $this->fetch_model->getClientList3($this->ion_auth->user()->row()->id);

				$data['error'] = validation_errors();

				$this->load->view('template/header.php');
				$this->load->view('dashboard_profile.php', $data);
				$this->load->view('template/footer.php');
			}
			else
			{
				$this->crud_model->database=$this->load->database();

				$profileID = $this->ion_auth->user()->row()->id;

				$data = array(
		       'user_extra_info_address' => $this->input->post('registerAddress'),
		       'user_extra_info_birthday' => $this->input->post('registerBirthday')
		    );
				$update = $this->crud_model->registerUserExtraInfoEdit(array('user_extra_info_user_id' => $profileID),	$data);

				//
				$data = array(
		       'first_name' => $this->input->post('registerFirstName'),
		       'last_name' => $this->input->post('registerLastName'),
 		       'email' => $this->input->post('registerEmail'),
 		       'phone' => $this->input->post('registerPhone')
		    );

				$update = $this->crud_model->userUpdate(array('id' => $profileID),	$data);
				if($update)
				{
					$data['message'] = "Profile updated.";

					$data['services'] = $this->fetch_model->getServicesList();
					$data['provider'] = $this->fetch_model->getProviderList();
					$data['client'] = $this->fetch_model->getClientList2();
					$data['userDetails'] = $this->fetch_model->getClientList3($this->ion_auth->user()->row()->id);

					$this->load->view('template/header_dashboard.php');
					$this->load->view('dashboard_profile.php', $data);
					$this->load->view('template/footer_dashboard.php');
				}

			}
		}
	}

}
