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
			$this->sendEmail($token);
			set_msg('success', "Congratulation! Check your email to activate your account");
			redirect('auth/login');
		}
	}

	private function sendEmail($token)
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
		$this->email->subject('Account verification');
		$this->email->message('Click this link to verify your account: <a href="' . base_url('auth/verify?email=') . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
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
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$authData = array(
			'username'  => $username,
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


	/**
	 * Forgot password page.
	 */
	public function forgot_password()
	{
		$this->redirectIfLogged();

		if ($this->isPOST()) {
			redirect(BASE_URL . "auth/process_forgot");
			return;
		}
		$this->render('Forgot Password', 'auth/forgot_password');
	}

	public function logout()
	{
		$this->Session->logout();
		redirect(URL_LOGIN);
	}
}
