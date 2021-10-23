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
  }

  public function create_new()
  {
    $data['title'] = 'Create Ticket';
    $this->render('ticket/create_new', $data);
  }

  public function list_all()
  {
    $data['title'] = 'List All Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable');
    $this->render('ticket/ticket_views', $data);
  }

  public function unassigned_tickets()
  {
    $data['title'] = 'Unassigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=null');
    $this->render('ticket/ticket_views', $data);
  }

  public function closed_tickets()
  {
    $data['title'] = 'Closed Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?status=100');
    $this->render('ticket/ticket_views', $data);
  }

  public function assigned_tickets()
  {
    $data['title'] = 'Assigned Tickets';
    $data['link'] = base_url('API/Ticket/generateDatatable?assign_to=not null');
    $this->render('ticket/ticket_views', $data);
  }

  public function assigned_to_me()
  {
    $data['title'] = 'Tickets assigned to me';
    $this->render('My Tickets', 'ticket/list_all', $data);
  }
  public function cc_to_me()
  {
    $data['title'] = 'Tickets followed by me';
    $data['type'] = "cc_to_me";
    $this->render('My Tickets', 'ticket/list_all', $data);
  }

  public function my_tickets()
  {
    $data['title'] = 'Tickets';
    $data['type'] = "My Tickets";
    $owner = $this->Session->getLoggedDetails()['username'];
    $data['link'] = base_url('API/Ticket/generateDatatable?owner=') . $owner;
    $this->render('ticket/ticket_views', $data);
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
      $data['info'] = $this->Tickets->getTableJoin(null, ['ticket_no' => $ticket], ['severities', 'services', 'subservices'], ['severity', 'id_service', 'id_subservice'], 'severities.name as name_severity, services.name as name_service, subservices.name as name_subservice');
      $data['messages'] = $this->Messages->getBy(null, ['ticket' => $ticket]);
      $this->render('ticket/view_ticket', $data);
    }
  }
}
