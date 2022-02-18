<?php

use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;

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
    $select = "ticket_no, owner, purpose,message, assign_to, assign_on, tickets.status, data";
    $join = ['priority', 'services', 'subservices', 'users'];
    $columnjoin = ['id_priority', 'id_service', 'id_subservice', 'assign_to'];
    $as = 'priority.name as priority, services.name as service, subservices.name as subservice, users.username as username';
    $action = [true, 'view_ticket', 'ticket_no'];

    if (($this->input->get())) {
      $input = $this->input->get();

      // Get first key in array from url 
      $key = array_keys($input)[0];

      // Get value in array from url
      $val = array_values($input)[0];

      // Process generate datatable
      echo $this->Tickets->generateDatatable($select, [$key => $val], $join, $columnjoin, $as, $action);
    } else {
      echo $this->Tickets->generateDatatable($select, null, $join, $columnjoin, $as, $action);
    }
  }

  public function create()
  {
    $create = $this->Tickets->create($_POST);
    $this->session->set_flashdata('success', 'Create ticket success, Please check your email for new update');
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

  /**
   * For upload data to google drive
   */
  public function upload_attachment()
  {
    if (isset($_POST) && $this->session->userdata('access_token')) {
      // If access token found, set access token for client
      $this->client->setAccessToken($this->session->userdata('access_token'));

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
      $allowTypes = array('xlsx', 'png', 'jpeg', 'jpg', "zip", "rar", "docx", "doc", "xls", "csv", "pdf");

      if (in_array($fileType, $allowTypes) && $this->client->getAccessToken()) {
        // Create file object for upload to drive
        $file = new DriveFile();
        // Set name on folder google drive 
        $file->setName($fileName);
        $file->setParents([getenv("DRIVE_PARENT_FOLDER")]);
        // Create drive object for connect google drive
        $service = new Drive($this->client);
        // Upload file process
        $result = $service->files->create(
          $file,
          array(
            'data' => file_get_contents($_FILES['file']['tmp_name']),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'multipart'
          )
        );
        // Handle if data is'nt docx, so get web view link
        $file = $service->files->get($result->getId(), array('fields' => 'webViewLink'));
        // add permission to anyone who has link
        $permission = new Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');
        try {
          $service->permissions->create($result['id'], $permission);
        } catch (Exception $e) {
          print_r($e);
        }
        // Send response to frontend
        $response['filename'] = $file->getWebViewLink();
        $response['original_file_name'] = $_FILES["file"]["name"];
        $response['status'] = 'ok';
      } else {
        $response['status'] = 'type_err';
      }
      echo json_encode($response);
    }
  }

  public function updateTicket()
  {
    $update = $this->Tickets->updateTicket($_POST['update_data']);
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
      'ticket' => htmlspecialchars($this->input->post('ticket_no')),
      'message' => $this->input->post('message'),
      'data' => json_encode($this->input->post('data')),
      'owner' => $this->Session->getLoggedDetails()['username'],
      'created' => time(),
      'type' => htmlspecialchars($this->input->post('type'))
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
