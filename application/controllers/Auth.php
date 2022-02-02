<?PHP

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setHeaderFooter('auth/header.php', 'auth/footer.php');
		$this->load->model('user/Auth_model', 'Auth');
	}

	private function redirectIfLogged()
	{
		if ($this->Session->isLoggedin()) {
			var_dump($this->Session->getUserType());
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
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required|trim'
			],
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
				'rules' => 'required|trim|valid_email',
			],
			[
				'field' => 'mobile',
				'label' => 'Mobile',
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
				'name' => $this->input->post('name', true),
				'username' => $this->input->post('username', true),
				'email' => $this->input->post('email', true),
				'mobile' => $this->input->post('mobile', true),
				'password' => md5($this->input->post('password1', true)),
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
			$this->db->insert('users_token', $userToken);
			$this->_sendEmail($token);
			redirect('auth/login');
		}
	}

	private function _sendEmail($token)
	{
		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp:googlemail.com',
			'smtp_user' => '',
			'smtp_pass' => '',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];

		$this->email->initialize($config);
		$this->email->from('', '');
		$this->email->to($this->input->post('email'));
		$this->email->subject('Account verification');
		$this->email->message(urlencode($token));
		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
		}
	}

	/**
	 * Login landing page.
	 */
	public function login()
	{
		$this->requirePermissions(PERMISSION_AUTH_LOGIN);
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
		if (!$result) {
			set_msg('error', 'Invalid username or password!');
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
