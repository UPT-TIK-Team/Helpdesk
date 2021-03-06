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
				'rules' => 'required|trim|valid_email|is_unique[users.email]|callback_validate_email',
				'errors' => [
					'is_unique' => 'This email has already registered',
					'validate_email' => 'Please use unsika email'
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
			// Fill initial account field in database
			$data = array(
				'username' => htmlspecialchars($this->input->post('username', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'mobile' => htmlspecialchars($this->input->post('phoneNumber', true)),
				'password' => password_hash(($this->input->post('password1')), PASSWORD_DEFAULT),
				'type' => 10,
				'status' => 1,
				'created' => time()
			);
			$this->db->insert('users', $data);
			$this->session->set_flashdata('success', "Please login to continue!");
			redirect('auth/login');
		}
	}

	/**
	 * Function to validate unsika email
	 */
	public function validate_email($email)
	{
		// Return not false if email contains 'unsika.ac.id'
		return strpos($email, 'unsika.ac.id') !== false;
	}

	/**
	 * Login landing page.
	 */
	public function login()
	{
		$this->redirectIfLogged();
		if ($this->isPOST()) {
			if ($this->process_login()) {
				return;
			}
		}
		$this->client->setRedirectUri(BASE_URL . 'user/dashboard');
		$this->client->addScope(['email', 'profile']);
		$data['google_login_url'] = $this->client->createAuthUrl();
		$this->render('auth/login', $data);
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
		// Check result if array it means that it doesn't contains error
		if (!is_array($result)) {
			$this->session->set_flashdata('failed', $result);
			return false;
		} else {
			$this->Session->login($result['id'], $this->Session->getDefaultPermissions($result['type']), $result);
			$id = $this->session->userdata()['sessions_details']['id'];
			$userdata = $this->db->get_where('users', ['id' => $id])->row_array();
			// If refresh token is available set new access token from google client
			if ($userdata['refresh_token']) {
				$newAccessToken = $this->client->refreshToken(base64_decode($userdata['refresh_token']));
				$this->session->set_userdata('access_token', $newAccessToken['access_token']);
			}
			// Redirect to appropriate url
			switch ($this->Session->getUserType()) {
				case USER_ADMIN:
					redirect(URL_POST_LOGIN_ADMIN);
				case USER_MEMBER:
					redirect(URL_POST_LOGIN_USER);
				case USER_AGENT:
					redirect(URL_POST_LOGIN_AGENT);
				case USER_MANAGER:
					redirect(URL_POST_LOGIN_MANAGER);
			}
			return true;
		}
	}

	public function logout()
	{
		session_destroy();
		redirect('auth/login');
	}

	public function forgotPassword()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == false) {
			$this->render('auth/forgot_password');
		} else {
			$email = htmlspecialchars($this->input->post('email', true));
			$user = $this->db->get_where('users', ['email' => $email, 'status' => 1])->row_array();

			// If user not found just redirect to forgotpassword page and set alert
			if (!$user) {
				$this->session->set_flashdata('failed', 'Email is not registered or activated');
				redirect('auth/forgotpassword');
			}

			// Create token from random byte
			$token = base64_encode(random_bytes(32));

			// Prepare data for inserting in database
			$userToken = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];
			$this->db->insert('users_token', $userToken);

			// Set data for send email
			$emailData = [
				'email' => $email,
				'token' => $token
			];
			sendEmail('forgotpassword', $emailData);
			$this->session->set_flashdata('success', 'Please check your email to reset password');
			redirect('auth/forgotpassword');
		}
	}

	public function resetpassword()
	{
		$email = $this->input->get('email', true);
		$token = $this->input->get('token', true);
		$user = $this->db->get_where('users', ['email' => $email])->row_array();
		if (!$user) {
			$this->session->set_flashdata('failed', 'Reset password failed');
			redirect('auth/login');
		}
		$user_token = $this->db->get_where('users_token', ['token' => $token])->row_array();
		if (!$user_token) {
			$this->session->set_flashdata('failed', 'Account activation failed! wrong token');
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
			$this->session->set_flashdata('success', "Password has been changed, Please login");
			redirect('auth/login');
		}
	}
}
