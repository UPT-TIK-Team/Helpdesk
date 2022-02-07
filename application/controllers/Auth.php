<?PHP

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setHeaderFooter('auth/header.php', 'auth/footer.php');
		$this->load->model('user/Auth_model', 'Auth');
		$this->load->model('user/User_model', 'User');
	}

	private function redirectIfLogged()
	{
		if ($this->Session->isLoggedin()) {
			if ($this->Session->getUserType() === USER_ADMIN)
				redirect(URL_POST_LOGIN_ADMIN);
			else if ($this->Session->getUserType() == USER_MEMBER)
				redirect(URL_POST_LOGIN_USER);
			else if ($this->Session->getUserType() == USER_AGENT)
				redirect(URL_POST_LOGIN_AGENT);
			else if ($this->Session->getUserType() == USER_MANAGER)
				redirect(URL_POST_LOGIN_MANAGER);
			else if ($this->Session->getUserType() == USER_LIMITED)
				redirect(URL_POST_LOGIN_LIMITED);
			return true;
		}
		return false;
	}



	public function index()
	{
		$this->load->view('auth/home');
	}


	/**
	 * unauthorized landing page
	 */
	public function unauthorized()
	{
		$this->render('Unauthorized', 'auth/unauthorized');
	}


	/**
	 * Registration landing page
	 */
	public function register()
	{
		$config = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|trim|is_unique[users.username]',
				'errors' => [
					'is_unique' => 'This username has already registered'
				]
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|trim|valid_email|is_unique[users.email]',
				'errors' => [
					'is_unique' => 'This email has already registered'
				]
			],
			[
				'field' => 'phoneNumber',
				'label' => 'PhoneNumber',
				'rules' => 'required|trim'
			],
			[
				'field' => 'password1',
				'label' => 'Password1',
				'rules' => 'required|trim|min_length[3]|matches[password2]',
				'errors' => [
					'min_length' => 'Password too short',
					'matches' => 'Password does\'nt match'
				]
			],
			[
				'field' => 'password2',
				'label' => 'Password',
				'rules' => 'required|trim|matches[password1]'
			],
		];
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == false) {
			$this->redirectIfLogged();
			$data['title'] = 'Register';
			$this->render('auth/register', $data);
		} else {
			$data = array(
				'username' => htmlspecialchars($this->input->post('username', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'mobile' => htmlspecialchars($this->input->post('phoneNumber', true)),
				'password' => password_hash(($this->input->post('password1')), PASSWORD_DEFAULT),
				'type' => 10,
				'status' => 0,
				'created' => time()
			);
			$token = base64_encode(random_bytes(32));
			$userToken = [
				'email' => $data['email'],
				'token' => $token,
				'date_created' => time()
			];
			$this->db->insert('users', $data);
			$this->db->insert('users_token', $userToken);
			$this->sendEmail($token, 'verify');
			set_msg('success', "Congratulation! Check your email to activate your account");
			redirect('auth/login');
		}
	}

	private function sendEmail($token, $type)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => getenv("EMAIL_ADDRESS"),
			'smtp_pass' => getenv("EMAIL_PASSWORD"),
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];
		$this->email->initialize($config);
		$this->email->from(getenv("EMAIL_ADDRESS"), getenv("EMAIL_SUBJECT"));
		$this->email->to($this->input->post('email'));
		switch ($type) {
			case 'verify':
				$this->email->subject('Account verification');
				$this->email->message('Click this link to verify your account: <a href="' . base_url('auth/verify?email=') . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
				break;
			case 'forgotpassword':
				$this->email->subject('Reset password');
				$this->email->message('Click this link to reset your password: <a href="' . base_url('auth/resetpassword?email=') . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
				break;
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	public function verify()
	{
		$email = $this->input->get('email', true);
		$token = $this->input->get('token', true);
		$user = $this->User->getUsersBy('users', ['email' => $email]);
		if (!$user) {
			set_msg('error', "Account activation failed! wrong email address");
			redirect('auth/login');
		}
		$user_token = $this->db->get_where('users_token', ['token' => $token])->row_array();
		if (!$user_token) {
			set_msg('error', "Account activation failed! wrong token");
			redirect('auth/login');
		}
		if (time() - $user_token['date_created'] > 60 * 60 * 24) {
			$this->db->delete('users', ['email' => $email]);
			set_msg('error', "Account activation failed! token expired");
			redirect('auth/login');
		}
		$this->db->update('users', ['status' => 1], ['email' => $email]);
		$this->db->delete('users_token', ['email' => $email]);
		set_msg('success', "Account activation success, please login to continue");
		redirect('auth/login');
	}

	/**
	 * Login landing page.
	 */
	public function login()
	{
		$this->redirectIfLogged();
		if ($this->isPOST()) {
			if ($this->process_login())
				return;
		}
		$this->render('auth/login');
	}

	/**
	 * Login processing logic
	 * @return bool
	 */
	private function process_login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$authData = array(
			'email'  => $email,
			'password'  => $password,
		);
		$result = $this->Auth->login($authData);
		if ($result === "Check your email to activate your account!" || $result === "Wrong password" || $result === "User not found") {
			set_msg('error', $result);
			return false;
		} else {
			$this->Session->login($result['id'], $this->Session->getDefaultPermissions($result['type']), $result);
			if ($this->Session->getUserType() === USER_ADMIN)
				redirect(URL_POST_LOGIN_ADMIN);
			else if ($this->Session->getUserType() == USER_MEMBER)
				redirect(URL_POST_LOGIN_USER);
			else if ($this->Session->getUserType() == USER_AGENT)
				redirect(URL_POST_LOGIN_AGENT);
			else if ($this->Session->getUserType() == USER_MANAGER)
				redirect(URL_POST_LOGIN_MANAGER);
			else if ($this->Session->getUserType() == USER_LIMITED)
				redirect(URL_POST_LOGIN_LIMITED);
			return true;
		}
	}

	public function logout()
	{
		session_destroy();
		redirect(URL_LOGIN);
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$this->render('auth/forgot_password');
		} else {
			$email = $this->input->post('email', true);
			$user = $this->db->get_where('users', ['email' => $email, 'status' => 1])->row_array();
			if (!$user) {
				set_msg('error', "Email is not registered or activated");
				redirect('auth/forgotpassword');
			}
			$token = base64_encode(random_bytes(32));
			$userToken = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];
			$this->db->insert('users_token', $userToken);
			$this->sendEmail($token, 'forgotpassword');
			set_msg('success', "Please check your email to reset password");
			redirect('auth/forgotpassword');
		}
	}

	public function resetpassword()
	{
		$email = $this->input->get('email', true);
		$token = $this->input->get('token', true);
		$user = $this->db->get_where('users', ['email' => $email])->row_array();
		if (!$user) {
			set_msg('error', "Reset password failed");
			redirect('auth/login');
		}
		$user_token = $this->db->get_where('users_token', ['token' => $token])->row_array();
		if (!$user_token) {
			set_msg('error', "Account activation failed! wrong token");
			redirect('auth/login');
		}
		$this->session->set_userdata('reset_email', $email);
		redirect('auth/changePassword');
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) redirect('auth/login');
		$config = [
			[
				'field' => 'password1',
				'label' => 'Password1',
				'rules' => 'required|trim|min_length[3]|matches[password2]',
				'errors' => [
					'min_length' => 'Password too short',
					'matches' => 'Password does\'nt match'
				]
			],
			[
				'field' => 'password2',
				'label' => 'Password',
				'rules' => 'required|trim|matches[password1]'
			],
		];
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() == false) {
			$this->render('auth/change_password');
		} else {
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_email');
			$this->db->update('users', ['password' => $password], ['email' => $email]);
			$this->session->unset_userdata('reset_email');
			set_msg('success', "Password has been changed, Please login");
			redirect('auth/login');
		}
	}
}
