<?php

class Ticket extends MY_Controller
{
  function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    parent::__construct();
    parent::requireLogin();
    $this->load->model('core/Session_model', 'Session');
    $this->load->model('ticket/Ticket_model', 'Tickets');
    $this->load->model('user/User_model', 'Users');
  }

  public function generateDatatable()
  {
    $select = "ticket_no, owner, purpose, subject, message, assign_to, assign_on, status, data";
    $join = ['priority', 'services', 'subservices'];
    $columnjoin = ['id_priority', 'id_service', 'id_subservice'];
    $as = 'priority.name as priority, services.name as service, subservices.name as subservice';
    $action = [true, 'view_ticket', 'ticket_no'];

    if ($this->input->get()) {
      $input = $this->input->get();
      $key = array_keys($input)[0];
      $val = array_values($input)[0];
      if ($key == 'assign_to' && $val == 'null') {
        echo $this->Tickets->generateDatatable($select, ['assign_to is null', 'NULL', 'FALSE'], $join, $columnjoin, $as, $action);
      } else if ($key == 'assign_to' && $val == 'not null') {
        echo $this->Tickets->generateDatatable($select, ['assign_to is not null', 'NULL', 'FALSE'], $join, $columnjoin, $as, $action);
      } else if ($key == 'assign_to' && !empty($val)) {
        echo $this->Tickets->generateDatatable($select, [$key => $val], $join, $columnjoin, $as, $action);
      } else {
        echo $this->Tickets->generateDatatable($select, [$key => $val], $join, $columnjoin, $as, $action);
      }
    } else {
      echo $this->Tickets->generateDatatable($select, null, $join, $columnjoin, $as, $action);
    }
  }

  public function create()
  {
    $create = $this->Tickets->create($_POST);
    $this->sendJSON(array('result' => $create));
  }

  public function getStatus()
  {
    $this->sendJSON($this->Tickets->getAllStatus());
  }

  public function getServices()
  {
    $this->sendJSON($this->Tickets->getServices());
  }

  public function getSubServices($id = null)
  {
    if ($id == null) return $this->sendJSON($this->Tickets->getAllSubServices());
    $this->sendJSON($this->Tickets->getSubServicesById($id));
  }

  public function getPriorities()
  {
    $this->sendJSON($this->Tickets->getAllPriorities());
  }

  public function getSeverities()
  {
    $this->sendJSON($this->Tickets->getAllSeverities());
  }

  public function getPriority($id = null)
  {
    $this->sendJSON($this->Tickets->getPriority($id));
  }

  public function upload_attachment()
  {

    if (isset($_POST) == true) {
      //generate unique file name
      date_default_timezone_set('Asia/Jakarta');
      $curr_date = date('dmY');
      $curr_time = date('His');
      $fileName = $curr_date . $curr_time . '-' . basename($_FILES["file"]["name"]);
      $fileName = str_replace(" ", "_", $fileName);

      //file upload path
      $targetDir = "uploads/";
      if (!is_dir($targetDir)) mkdir($targetDir, 0777);
      $targetFilePath = $targetDir . $fileName;

      //allow certain file formats
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
      $allowTypes = array('xlsx', 'png', 'jpeg', 'jpg', "zip", "rar", "docx", "doc", "xls", "csv");

      if (in_array($fileType, $allowTypes)) {
        //upload file to server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
          //insert file data into the database if needed
          $response['filename'] = base_url('uploads/') . $fileName;
          $response['original_file_name'] = $_FILES["file"]["name"];
          $response['status'] = 'ok';
        } else {
          $response['status'] = 'err';
        }
      } else {
        $response['status'] = 'type_err';
      }

      //render response data in JSON format
      echo json_encode($response);
    }
  }

  public function updateTicket()
  {
    $update = $this->Tickets->updateTicket($_POST['update_data'], $_POST['meta']);
    $thread_data = [
      'ticket' => $_POST['meta']['ticket_no'],
      'message' => $_POST['meta']['message'],
      'owner' => $this->Session->getLoggedDetails()['username'],
      'created' => time(),
      'type' => (int)$_POST['meta']['type']
    ];
    $this->Tickets->add_thread($thread_data);
    $this->sendJSON(array('result' => $update));
  }

  public function addThreadMessage()
  {
    $thread_data = [
      'ticket' => $this->input->post('ticket_no'),
      'message' => $this->input->post('message'),
      'data' => json_encode($this->input->post('data')),
      'owner' => $this->Session->getLoggedDetails()['username'],
      'created' => time(),
      'type' => $this->input->post('type')
    ];
    if (trim($thread_data['message']) == '') {
      $this->sendJSON(array('result' => -1));
    } else {
      $res = $this->Tickets->add_thread($thread_data);
      if ($thread_data['data'] == null) {
        $this->Tickets->addAttachmentRef($this->input->post('data')['attachments'],  $this->input->post('ticket_no'));
      }
      $this->sendJSON(array('result' => $res));
    }
  }
}
