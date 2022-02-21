<?php

class User extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		parent::requireLogin();
		$this->setHeaderFooter('global/header.php', 'global/footer.php');
		$this->load->model('core/Session_model', 'Session');
		$this->load->model('ticket/Threads_model', 'Tickets');
		$this->load->model('user/User_model', 'Users');
		// Check new_update session, if session exist redirect to destination url
		if (isset($_SESSION['new_update'])) redirect(base_url($this->session->flashdata('new_update')));
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard';
		$role = (int)($this->Session->getUserType());
		$id = $this->session->userdata()['sessions_details']['id'];
		$userdata = $this->db->get_where('users', ['id' => $id])->row_array();
		// If refresh token is available set new access token from google client
		if ($userdata['refresh_token']) {
			$newAccessToken = $this->client->refreshToken(base64_decode($userdata['refresh_token']));
			$this->session->set_userdata('access_token', $newAccessToken['access_token']);
		}
		switch ($role) {
			case USER_MEMBER:
				$this->dashboard_member();
				break;
			case USER_AGENT:
				$this->dashboard_agent();
				break;
			case USER_MANAGER:
				$this->dashboard_manager();
				break;
			default:
				$this->dashboard_manager();
		}
	}

	public function dashboard_member()
	{
		$data['title'] = 'Dashboard';
		$agent_id = $this->Session->getLoggedDetails()['username'];
		$data['stats']['total_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id)));
		$data['stats']['open_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_OPEN)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['closed_tickets'] = count($this->Tickets->get_ticket_where(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
		$data['recent']['created'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id), 5);
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('owner' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		$this->render('user/dashboard_user', $data);
	}

	public function dashboard_agent()
	{
		$data['title'] = 'Dashboard';
		$agent_id = $this->Session->getLoggedDetails()['id'];
		$data['stats']['total_tickets'] = count($this->Tickets->getBy(null, array()));
		$data['stats']['assigned_tickets'] = count($this->Tickets->get_ticket_where(array('assign_to' => $agent_id)));
		$data['stats']['closed_tickets'] = count($this->Tickets->getBy(null, array('assign_to' => $agent_id, 'status' => TICKET_STATUS_CLOSED)));
		$data['recent']['assigned'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->get_ticket_where_limit(array('assign_to' => $agent_id, 'status' => TICKET_STATUS_CLOSED), 5);
		// Check in session if status inactive, redirect to change password pages
		if ((int)$this->Session->getLoggedDetails()['status'] === USER_STATUS_INACTIVE) {
			$this->session->set_flashdata('change_password', 'Please change your password');
			redirect(BASE_URL . 'user/change_password');
		}
		// Check in session if update account is exist it mean username from actual user is null,so redirect to profile update pages
		if ($this->session->flashdata('update_account')) redirect('user/profile_update');
		$this->render('user/dashboard', $data);
	}

	public function dashboard_manager()
	{
		$data['title'] = 'Dashboard';
		$data['stats']['total_tickets'] = count($this->Tickets->getBy(null, array()));
		$data['stats']['open_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_OPEN)));
		$data['stats']['assigned_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_ASSIGNED)));
		$data['stats']['closed_tickets'] = count($this->Tickets->getBy(null, array('status' => TICKET_STATUS_CLOSED)));

		$data['stats']['total_users'] = count($this->Users->getBy(null, array('type' => USER_MEMBER), null, true));
		$data['stats']['total_agents'] = count($this->Users->getBy(null, array('type' => USER_AGENT), null, true));
		$data['stats']['total_manager'] = count($this->Users->getBy(null, array('type' => USER_MANAGER), null, true));

		$data['stats']['count_by_priority']['critical'] = array(
			count($this->Tickets->getBy(null, array('id_priority' => 4, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('id_priority' => 4, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('id_priority' => 4, 'status' => TICKET_STATUS_CLOSED)))
		);

		$data['stats']['count_by_priority']['high'] = array(
			count($this->Tickets->getBy(null, array('id_priority' => 3, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('id_priority' => 3, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('id_priority' => 3, 'status' => TICKET_STATUS_CLOSED)))
		);

		$data['stats']['count_by_priority']['medium'] = array(
			count($this->Tickets->getBy(null, array('id_priority' => 2, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('id_priority' => 2, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('id_priority' => 2, 'status' => TICKET_STATUS_CLOSED)))
		);

		$data['stats']['count_by_priority']['low'] = array(
			count($this->Tickets->getBy(null, array('id_priority' => 1, 'status' => TICKET_STATUS_OPEN))),
			count($this->Tickets->getBy(null, array('id_priority' => 1, 'status' => TICKET_STATUS_ASSIGNED))),
			count($this->Tickets->getBy(null, array('id_priority' => 1, 'status' => TICKET_STATUS_CLOSED)))
		);
		$data['recent']['created'] = $this->Tickets->getBy(null, array(), 5);
		$data['recent']['open'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_OPEN), 5);
		$data['recent']['assigned'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_ASSIGNED), 5);
		$data['recent']['closed'] = $this->Tickets->getBy(null, array('status' => TICKET_STATUS_CLOSED), 5);
		$this->render('user/dashboard_manager', $data);
	}

	public function profile()
	{
		$data['title'] = 'Profile';
		$id = $this->Session->getLoggedDetails()['id'];
		$data['user_details'] = $this->Users->getUserBy(array('id' => $id));
		$this->render('user/profile', $data);
	}


	public function change_password()
	{
		$data['title'] = 'Change Password';
		$this->render('user/change_password', $data);
	}

	public function profile_update()
	{
		// Get user details by username
		$username = $this->Session->getLoggedDetails()['username'];
		$data['user_details'] = $this->Users->getUserBy(array('username' => $username));
		// Initial is_unique as array of object
		$is_unique = [
			'username' => '',
			'email' => '',
			'mobile' => ''
		];
		// Set is unique array based on username field
		if ($this->input->post('username') !== $data['user_details']['username']) {
			$is_unique['username'] = '|is_unique[users.username]';
		} else {
			$is_unique['username'] = '';
		}
		// Set is unique array based on email field
		if ($this->input->post('email') !== $data['user_details']['email']) {
			$is_unique['email'] = '|is_unique[users.email]';
		} else {
			$is_unique['email'] = '';
		}
		// Set is unique array based on mobile field
		if ($this->input->post('mobile') !== $data['user_details']['mobile']) {
			$is_unique['mobile'] = '|is_unique[users.mobile]';
		} else {
			$is_unique['mobile'] = '';
		}
		$config = [
			[
				'field' => 'username',
				'label' => 'username',
				'rules' => 'required|trim' . $is_unique['username'],
				'errors' => [
					'is_unique' => 'This username has already registered'
				]
			],
			[
				'field' => 'email',
				'label' => 'email',
				'rules' => 'required|trim|valid_email|callback_validate_email' . $is_unique['email'],
				'errors' => [
					'is_unique' => 'This email has already registered',
					'validate_email' => 'Please use unsika email'
				]
			],
			[
				'field' => 'mobile',
				'label' => 'mobile',
				'rules' => 'required|trim' . $is_unique['mobile'],
				'errors' => [
					'is_unique' => 'This phone has already registered'
				]
			],
		];
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === false) {
			$data['title'] = 'Profile Update';
			$this->render('user/profile_update', $data);
		} else {
			$data = [
				'id' => $data['user_details']['id'],
				'username' => htmlspecialchars($this->input->post('username', true)),
				'email' => htmlspecialchars($this->input->post('email', true)),
				'mobile' => htmlspecialchars($this->input->post('mobile', true))
			];
			$this->Users->updateProfile($data);
			if ($this->session->flashdata('update_account')) unset($_SESSION['update_account']);
			redirect('user/profile');
		}
	}


	/**
	 * Function to validate unsika email
	 */
	function validate_email($email)
	{
		// Return not false if email contains 'unsika.ac.id'
		return strpos($email, 'unsika.ac.id') !== false;
	}


	public function list()
	{
		$data['title'] = 'List All Users';
		$role = $this->Session->getLoggedDetails()['type'];
		$filter = ['type <=' => $role];
		$data['user_list'] = $this->Users->getBy(null, $filter);
		$this->render('user/list_user', $data);
	}

	public function generateDatatable()
	{
		$select = "email, mobile, username, type, status, created";
		echo $this->Users->generateDatatable($select, null, null, null, null);
	}

	public function add_user()
	{
		$email = htmlspecialchars($this->input->post('email', true));
		$password = generate_random_password();
		$type = htmlspecialchars($this->input->post('type', true));
		$data = [
			'email' => $email,
			'password' => password_hash($password, PASSWORD_DEFAULT),
			'type' => $type,
			'status' => USER_STATUS_INACTIVE,
			'created' => time()
		];
		$this->db->insert('users', $data);
		$this->session->set_userdata(['email' => $data['email'], 'password' => $password]);
		redirect('user/list');
	}

	public function changeStatusUser($id)
	{
		$data['title'] = 'Change Status';
		$user = $this->Users->getUserBy(array('id' => $id));
		if ($user['status'] == 0) {
			$user['status'] = 1;
		} else {
			$user['status'] = 0;
		}
		$role = $this->Session->getLoggedDetails()['type'];
		$filter = ['type <=' => $role];
		$data['user_list'] = $this->Users->getBy(null, $filter);
		$this->render('user/list', $data);
	}

	/**
	 * Function for handle user guide menu
	 */
	public function userGuide()
	{
		$data['title'] = 'User Guide';
		$this->render('user/user_guide', $data);
	}
}
