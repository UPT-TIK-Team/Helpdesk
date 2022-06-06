<?php
class Tickets extends MY_Controller
{
  private $id;
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('ticket/Ticket_model', 'Tickets');
    $this->load->model('user/User_model', 'Users');
    $this->load->model('ticket/Messages_model', 'Messages');
    $this->id = $this->session->userdata()['sessions_details']['id'];
    // Check change password session, if exist redirect to change password page
    if ($this->session->flashdata('change_password')) redirect(BASE_URL . 'user/change_password');
    // Check in session if update account is exist it mean username from actual user is null,so redirect to profile update pages
    if ($this->session->flashdata('update_account')) redirect('user/profile_update');
  }

  public function create_new()
  {
    if (!$this->session->userdata('access_token')) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/create_new');
      $loginButton = '<a href="' . $this->client->createAuthUrl() . '" >Unsika Google Email!</a>';
      $data['loginButton'] = $loginButton;
    }
    if (isset($_GET["code"])) {
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $this->id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    }
    $data['title'] = 'Buat Tiket';
    $this->render('ticket/create_new_ticket_view', $data);
  }

  public function list_all()
  {
    $data['title'] = 'Daftar Seluruh Tiket';
    $data['link'] = base_url('API/Ticket_API/generateDatatable');
    if (isset($_GET["code"])) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/list_all');
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $this->id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    }
    $this->render('ticket/ticket_table_view', $data);
  }

  public function unassigned_tickets()
  {
    $data['title'] = 'Tiket Yang Belum Ditugaskan';
    $data['link'] = base_url('API/Ticket_API/generateDatatable?assign_to=0');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function closed_tickets()
  {
    $data['title'] = 'Tiket Selesai';

    // Data link is use to create datatables from folder 'controllers/API/Ticket with appropriate url'
    $data['link'] = base_url('API/Ticket_API/generateDatatable?status=100');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function assigned_tickets()
  {
    $data['title'] = 'Tiket Yang Ditugaskan';

    // Data link is use to create datatables from folder 'controllers/API/Ticket with appropriate url'

    $data['link'] = base_url('API/Ticket_API/generateDatatable?assign_to=!=0');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function assigned_to_me()
  {
    $data['title'] = 'Tiket Untuk Saya';
    $assign_to = $this->Session->getLoggedDetails()['id'];

    // Data link is use to create datatables from folder 'controllers/API/Ticket with appropriate url'
    $data['link'] = base_url('API/Ticket_API/generateDatatable?assign_to=') . $assign_to;
    if (isset($_GET["code"])) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/assigned_to_me');
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $this->id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    }
    $this->render('ticket/ticket_table_view', $data);
  }

  public function my_tickets()
  {
    $data['title'] = 'Tiket Saya';
    $data['type'] = "My Tickets";
    $owner = $this->Session->getLoggedDetails()['username'];

    // Data link is use to create datatables from folder 'controllers/API/Ticket with appropriate url'
    $data['link'] = base_url('API/Ticket_API/generateDatatable?owner=') . $owner;
    if (isset($_GET["code"])) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/my_tickets');
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $this->id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    }
    $this->render('ticket/ticket_table_view', $data);
  }

  /**
   * Function for handle user access view_ticket url
   */
  public function view_ticket()
  {
    // Get ticket number from uri in segment 3
    $ticket_no = $this->uri->segment(3);

    // Get type from logged user
    $usertype = $this->Session->getLoggedDetails()['type'];

    $data['title'] = 'Lihat Tiket';
    $data['user_type'] = $usertype;
    $data['ticket_no'] = $ticket_no;
    $ticket_detail = $this->Tickets->get(['ticket_no' => $ticket_no]);

    // Parameters for database manipulation
    $select = null;
    $where = null;
    $join = array();
    $column = array();
    $as = null;

    // Handle if assign_to equal to 0
    if ((int)$ticket_detail['assign_to'] === 0) {
      // Fill parameter value
      $select = ['tickets.id', 'ticket_no', 'owner', 'purpose', 'message', 'assign_to', 'assign_on', 'tickets.created', 'status', 'data', 'tickets.id_service', 'tickets.id_subservice', 'tickets.id_priority'];
      $where = ['ticket_no' => $ticket_no];
      $join = ['services', 'subservices', 'priority', 'status'];
      $column = ['id_service', 'id_subservice', 'id_priority', 'status'];
      $as = 'services.name as name_service, subservices.name as name_subservice, priority.name as name_priority, status.name as name_status';

      // Execute join table query
      $data['info'] = $this->Tickets->getTableJoin($select, $where, $join, $column, $as);

      // Set username to empty
      $data['info']['username'] = '';
    } else {
      // Fill parameter value
      $select = null;
      $where = ['ticket_no' => $ticket_no];
      $join = ['services', 'subservices', 'priority', 'status', 'users'];
      $column = ['id_service', 'id_subservice', 'id_priority', 'status', 'assign_to'];
      $as = 'services.name as name_service, subservices.name as name_subservice, priority.name as name_priority,  status.name as name_status, username';

      // Execute join table query
      $data['info'] = $this->Tickets->getTableJoin($select, $where, $join, $column, $as);
    }

    /**
     * Get message by ticket no 
     */
    $select = null;
    $where = ['ticket' => $ticket_no];
    $data['messages'] = $this->Messages->getBy($select, $where);
    unset($_SESSION['new_update']);

    /**
     * Create login button if access_token not found in session
     * For google OAuth purpose
     */
    if (!$this->session->userdata('access_token')) {
      switch ($usertype) {
        case USER_MEMBER:
          $this->client->setRedirectUri(BASE_URL . 'tickets/my_tickets');
          break;
        case USER_AGENT:
          $this->client->setRedirectUri(BASE_URL . 'tickets/assigned_to_me');
          break;
        case USER_MANAGER:
          $this->client->setRedirectUri(BASE_URL . 'tickets/list_all');
          break;
      }
      $loginButton = '<a href="' . $this->client->createAuthUrl() . '" >Unsika Google Email!</a>';
      $data['loginButton'] = $loginButton;
    }
    $this->render('ticket/ticket_view', $data);
  }
}
