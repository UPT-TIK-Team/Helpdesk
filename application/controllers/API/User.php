<?php
require  __DIR__ . "/../../models/user/constants.php";

class User extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, OPTIONS");
    parent::requireLogin();
    $this->load->model('user/User_model', 'Users');
    $this->load->model('core/Session_model', 'Session');
  }

  public function getAll()
  {
    $types = array();
    if (isset($_GET['type'])) {
      $types = json_decode($_GET['type']);
    }
    $this->sendJSON($this->Users->getWhereFieldIn(array('id', 'email'), 'type', $types));
  }

  public function create()
  {
    $create = $this->Users->create($_POST);
    $this->sendJSON(array('result' => $create));
  }

  /**
   * Handle when user change password
   */
  public function change_password()
  {
    $user_id = $this->Session->getLoggedDetails()['id'];
    $new_password = $this->input->post('new_password');
    $update = ['status' => USER_STATUS_ACTIVE, 'password' => password_hash($new_password, PASSWORD_DEFAULT), 'updated' => time()];
    $update = $this->Users->update($user_id, $update);
    if ($update) {
      // Change status in session to active
      $_SESSION['sessions_details']['status'] = USER_STATUS_ACTIVE;
      // Unset session['change_password]
      unset($_SESSION['change_password']);
      redirect(base_url('user/dashboard'));
    }
  }

  public function add_user()
  {
    $userdata = [
      'name' => trim($this->input->post('name')),
      'email' => trim($this->input->post('email')),
      'mobile' => trim($this->input->post('mobile')),
      'username' => explode("@", $this->input->post('email'))[0],
      'password' => trim($this->input->post('password')),
      'type' => (int)$this->input->post('type'),
      'status' => USER_STATUS_ACTIVE,
      'created' => time(),
      'updated' => time()
    ];
    $user_id = $this->Users->register($userdata);
    $this->sendJSON(array('result' => $user_id));
  }

  public function changeStatusUser($id)
  {
    $user = $this->Users->getUserBy(array('id' => $id));
    if ($user['status'] == 0) {
      $user['status'] = 1;
    } else {
      $user['status'] = 0;
    }
    $role = $this->Session->getLoggedDetails()['type'];
    $filter = ['type <=' => $role];
    $data['user_list'] = $this->Users->getBy(null, $filter);
    $this->render('All Users', 'user/list', $data);
  }
}
