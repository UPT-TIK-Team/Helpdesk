<?PHP

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->setHeaderFooter('auth/header.php', 'auth/footer.php');
		$this->load->model('user/Auth_model', 'Auth');
		$this->load->model('core/Token_model', 'PIN');
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
			else if ($this->Session->getUserType() == USER_DEACTIVATED)
				redirect(URL_POST_LOGIN_DEACTIVATED);

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
				'status' => 1,
				'created' => time()
			);
			$this->Auth->add($data);
			redirect('auth/login');
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
			else if ($this->Session->getUserType() == USER_DEACTIVATED)
				redirect(URL_POST_LOGIN_DEACTIVATED);
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


	/**
	 * Process logic of forgot password
	 */
	public function process_forgot()
	{

		$username = trim($this->input->post('username'));
		if (empty($username)) {
			set_msg('error', 'Username required');
			redirect(BASE_URL . 'auth/forgot_password');
		}

		$user = $this->User->getByID(getUserID($username));
		if (empty($user)) {
			set_msg('error', 'Username not found in our record');
			redirect(BASE_URL . 'auth/forgot_password');
		}


		$emailOrMobile = trim($this->input->post('email'));
		if ($user['email'] == $emailOrMobile && $user['mobile'] !== $emailOrMobile) {
			set_msg('error', 'Email or Mobile number doesn\'t match.');
			redirect(BASE_URL . 'auth/forgot_password');
		}

		$password = mt_rand(100000, 999999);
		$hashedPassword = $this->User->hashPassword($password);

		$res = $this->User->update($user['id'], array('password' => $hashedPassword));
		if ($res) {
			$this->SMS->send($user['mobile'], 'Dear ' . $user['name'] . ', You new password for ' . $username . ' is ' . $password);
			set_msg('success', 'Password reset instructions have been sent to your number');
			redirect(BASE_URL . 'auth/forgot_password');
		} else {
			set_msg('error', 'There was some error processing your request!');
			redirect(BASE_URL . 'auth/forgot_password');
		}
	}

	public function logout()
	{
		$this->Session->logout();
		redirect(URL_LOGIN);
	}
}
