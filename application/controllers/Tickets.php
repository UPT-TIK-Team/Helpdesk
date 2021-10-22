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
    $this->render('New Ticket', 'ticket/create_new', $data);
  }

  public function list_all()
  {
    $data['title'] = 'Tickets';
    $data['type'] = "my_tickets";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }

  public function my_tickets()
  {
    $data['title'] = 'Tickets';
    $data['type'] = "my_tickets";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }

  public function assigned_to_me()
  {
    $data['title'] = 'Tickets assigned to me';
    $data['type'] = "assigned_to_me";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }
  public function cc_to_me()
  {
    $data['title'] = 'Tickets followed by me';
    $data['type'] = "cc_to_me";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }
  public function assigned_tickets()
  {
    $data['title'] = 'Assigned Tickets';
    $data['type'] = "assigned";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }
  public function unassigned_tickets()
  {
    $data['title'] = 'Unassigned Tickets';
    $data['type'] = "unassigned";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
  }

  public function closed_tickets()
  {
    $data['title'] = 'Closed Tickets';
    $data['type'] = "closed";
    $this->render('My Tickets', 'ticket/my_tickets', $data);
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
      $this->render('View Ticket', 'ticket/view_ticket', $data);
    }
  }
}
