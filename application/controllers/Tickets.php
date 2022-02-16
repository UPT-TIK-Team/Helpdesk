<?php


class Tickets extends MY_Controller
{
  function __construct()
  {
    parent::__construct();
    parent::requireLogin();
    $this->load->model('ticket/Ticket_model', 'Tickets');
    $this->load->model('user/User_model', 'Users');
    $this->load->model('ticket/Messages_model', 'Messages');
    if ($this->session->flashdata('change_password')) redirect(BASE_URL . 'user/change_password');
  }

  public function create_new()
  {
    $id = $this->session->userdata()['sessions_details']['id'];
    if (!$this->session->userdata('access_token')) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/create_new');
      $loginButton = '<a href="' . $this->client->createAuthUrl() . '" >Unsika Google Account!</a>';
      $data['loginButton'] = $loginButton;
    }
    if (isset($_GET["code"])) {
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    }
    $data['title'] = 'Create Ticket';
    $this->render('ticket/create_new_ticket_view', $data);
  }

  public function list_all()
  {
    $data['title'] = 'List All Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable');
    $id = $this->session->userdata()['sessions_details']['id'];
    if (isset($_GET["code"])) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/list_all');
      $token = $this->client->fetchAccessTokenWithAuthCode($_GET['code']);
      $this->db->update('users', ['refresh_token' => base64_encode($token['refresh_token'])], ['id' => $id]);
      $this->session->set_userdata('access_token', $token['access_token']);
    } else {
      $this->render('ticket/ticket_table_view', $data);
    }
  }

  public function unassigned_tickets()
  {
    $data['title'] = 'Unassigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=null');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function closed_tickets()
  {
    $data['title'] = 'Closed Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?status=100');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function assigned_tickets()
  {
    $data['title'] = 'Assigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=not null');
    $this->render('ticket/ticket_table_view', $data);
  }

  public function assigned_to_me()
  {
    $data['title'] = 'Tickets assigned to me';
    $assign_to = $this->Session->getLoggedDetails()['id'];
    $data['link'] = base_url('API/ticket/generateDatatable?assign_to=') . $assign_to;
    $this->render('ticket/ticket_table_view', $data);
  }

  public function my_tickets()
  {
    $data['title'] = 'Tickets';
    $data['type'] = "My Tickets";
    $owner = $this->Session->getLoggedDetails()['username'];
    $data['link'] = base_url('API/Ticket/generateDatatable?owner=') . $owner;
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

    $data['title'] = 'View Ticket';
    $data['privilege'] = ($usertype == USER_MANAGER) ? true : false;
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

      // Set users_email to null
      $data['info']['users_email'] = '';
    } else {
      // Fill parameter value
      $select = null;
      $where = ['ticket_no' => $ticket_no];
      $join = ['services', 'subservices', 'priority', 'status', 'users'];
      $column = ['id_service', 'id_subservice', 'id_priority', 'status', 'assign_to'];
      $as = 'services.name as name_service, subservices.name as name_subservice, priority.name as name_priority,  status.name as name_status, users.email as users_email';

      // Execute join table query
      $data['info'] = $this->Tickets->getTableJoin($select, $where, $join, $column, $as);
    }

    /**
     * Get message by ticket no 
     */
    $select = null;
    $where = ['ticket' => $ticket_no];
    $data['messages'] = $this->Messages->getBy($select, $where);

    /**
     * Create login button if access_token not found in session
     * For google OAuth purpose
     */
    if (!$this->session->userdata('access_token')) {
      $this->client->setRedirectUri(BASE_URL . 'tickets/list_all');
      $loginButton = '<a href="' . $this->client->createAuthUrl() . '" >Unsika Google Account!</a>';
      $data['loginButton'] = $loginButton;
    }
    $this->render('ticket/ticket_view', $data);
  }
}
