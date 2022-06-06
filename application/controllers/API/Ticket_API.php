<?php

use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;

class Ticket_API extends MY_Controller
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

    if (($this->input->get())) {
      $input = $this->input->get();

      // Get first key in array from url 
      $key = array_keys($input)[0];

      // Get value in array from url
      $val = array_values($input)[0];

      // Process generate datatable
      echo $this->Tickets->generateDatatable($select, [$key => $val], $join, $columnjoin, $as);
    } else {
      echo $this->Tickets->generateDatatable($select, null, $join, $columnjoin, $as);
    }
  }

  public function create()
  {
    $create = $this->Tickets->create($_POST);
    $this->session->set_flashdata('success', 'Terimakasih telah menggunakan layanan Helpdesk. Mohon kesediaan anda untuk mengisi kuesioner ini untuk penilaian terhadap kinerja sistem pakar pada layanan helpdesk');
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

      //allow certain file formats
      $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
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
        $response['original_file_name'] = $_FILES["file"]["name"];
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
      'message' => $this->input->post('message', true),
      'data' => json_encode($this->input->post('data')),
      'owner' => $this->Session->getLoggedDetails()['username'],
      'created' => time(),
      'type' => htmlspecialchars($this->input->post('type'))
    ];

    $res = $this->Tickets->add_thread($thread_data);
    if ($thread_data['data'] == null) {
      $this->Tickets->addAttachmentRef($this->input->post('data')['attachments'],  $this->input->post('ticket_no'));
    }

    // Check if message is null, so length for null values is 11
    if (strlen($thread_data['message']) !== 11) {
      $ticket_owner = $this->db->select('owner')->from('tickets')->where('ticket_no', $thread_data['ticket'])->get()->row_array();
      $email = $this->db->select('email, owner')->from('tickets')->where('ticket_no', $thread_data['ticket'])->join('users', 'users.username=owner')->get()->row_array();
      $data = [
        'email' => $email['email'],
        'ticket_no' => $thread_data['ticket'],
      ];

      // Check if ticket owner is different from message owner
      if ($ticket_owner['owner'] !== $thread_data['owner']) sendEmail('new_ticket_message', $data);
    }
    $this->sendJSON(array('result' => $res));
  }
}
