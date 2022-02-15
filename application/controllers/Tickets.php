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
    $this->render('ticket/CreateNewTicketView', $data);
  }

  public function list_all()
  {
    $data['title'] = 'List All Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable');
    $this->render('ticket/TicketsTableView', $data);
  }

  public function unassigned_tickets()
  {
    $data['title'] = 'Unassigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=null');
    $this->render('ticket/TicketsTableView', $data);
  }

  public function closed_tickets()
  {
    $data['title'] = 'Closed Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?status=100');
    $this->render('ticket/TicketsTableView', $data);
  }

  public function assigned_tickets()
  {
    $data['title'] = 'Assigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=not null');
    $this->render('ticket/TicketsTableView', $data);
  }

  public function assigned_to_me()
  {
    $data['title'] = 'Tickets assigned to me';
    $assign_to = $this->Session->getLoggedDetails()['username'];
    $data['link'] = base_url('API/ticket/generateDatatable?assign_to=') . $assign_to;
    $this->render('ticket/TicketsTableView', $data);
  }

  public function my_tickets()
  {
    $data['title'] = 'Tickets';
    $data['type'] = "My Tickets";
    $owner = $this->Session->getLoggedDetails()['username'];
    $data['link'] = base_url('API/Ticket/generateDatatable?owner=') . $owner;
    $this->render('ticket/TicketsTableView', $data);
  }

  public function view_ticket()
  {
    $ticket = $this->uri->segment(3);
    $data['title'] = 'View Ticket';
    $usertype = $this->Session->getLoggedDetails()['type'];
    $data['privilege'] = ($usertype == USER_MANAGER) ? true : false;
    if (!$ticket) {
      $this->render('View Ticket', 'unauthorised', $data);
    } else {
      $data['ticket_no'] = $ticket;
      $data['info'] = $this->Tickets->getTableJoin(null, ['ticket_no' => $ticket], ['services', 'subservices', 'priority', 'status'], ['id_service', 'id_subservice', 'id_priority', 'status'], 'services.name as name_service, subservices.name as name_subservice, priority.name as name_priority,  status.name as name_status');
      $data['messages'] = $this->Messages->getBy(null, ['ticket' => $ticket]);
      if (!$this->session->userdata('access_token')) {
        $this->client->setRedirectUri(BASE_URL . 'user/dashboard');
        $loginButton = '<a href="' . $this->client->createAuthUrl() . '" >Unsika Google Account!</a>';
        $data['loginButton'] = $loginButton;
      }
      $this->render('ticket/TicketView', $data);
    }
  }
}
