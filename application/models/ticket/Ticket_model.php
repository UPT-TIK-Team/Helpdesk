<?PHP

require  __DIR__ . "/constants.php";



class Ticket_model extends BaseMySQL_model
{

  public function __construct()
  {
    parent::__construct(TABLE_TICKETS);
    $this->load->model("core/Session_model", "Session");
    $this->load->model("user/User_model", "User");
    $this->load->model("notification/Email_model", "Email");
  }

  public function getByThread($tId)
  {
    $query = array('threadid' => $tId);
    return parent::getBy("*", $query);
  }

  public function getTicketNoFromID($id)
  {
    if (!$id)
      return "-";
    return CLIENT_TICKET_PREFIX . $this->pad($id, CLIENT_TICKET_ID_LENGTH);
  }
  public function pad($num, $size)
  {
    $s = (string)(1000000 + (int)$num);
    return substr($s, strlen($s) - $size);
  }

  public function create($data)
  {
    $info = getValuesOfKeys($data, array('owner', 'purpose', 'subject', 'message', 'assign_to', 'assign_on', 'severity', 'priority', 'id_service', 'id_subservice', 'data'));
    $attachments = $info['data'];
    $info['data'] = json_encode($info['data']);
    if (!$info['owner'])
      $info['owner'] = $this->Session->getLoggedDetails()['username'];
    if (!empty($info['subject']) && !empty($info['message'])) {
      $info = array_merge($info, array('ticket_no' => null, 'created' => time(), 'status' => TICKET_STATUS_OPEN));
      $res = $this->add($info);
      if ($res) {
        $ticket_no = $this->getTicketNoFromID($res);
        parent::setByID($res, array('ticket_no' => $ticket_no));
        // add attachment reference
        if (!empty($attachments['attachments'])) {
          $this->addAttachmentRef($attachments['attachments'], $ticket_no);
        }
        return $ticket_no;
      }
    } else $res = -1;

    return $res;
  }

  public function addAttachmentRef($attachments, $ref)
  {
    if ($attachments && !empty($attachments)) {
      $attach_ref = array();
      foreach ($attachments as $attachment) {
        array_push($attach_ref, array('ref' => $ref, 'name' => $attachment['file_name'], 'path' => $attachment['path'], 'uploaded_by' => $this->Session->getLoggedDetails()['username']));
      }

      return $this->db->insert_batch('attachments', $attach_ref);
    }
  }

  public function updateTicket($data)
  {
    if (!empty($data['id'])) {
      array_merge($data, array('updated' => time()));
      $res = parent::setByID($data['id'], $data);

      parent::getBy(array('owner', 'ticket_no', 'subject'), array('id' => $data['id']));
    } else $res = -1;

    return $res;
  }

  public function getAllCategories()
  {
    return $this->db->get('services')->result_array();
  }

  public function getAllSubServices()
  {
    return $this->db->get('subservices')->result_array();
  }

  public function getSubServicesById($idservice)
  {
    return $this->db->where('id_service', $idservice)->get('subservices')->result_array();
  }

  public function getAllPriorities()
  {
    return TICKET_PRIORITIES;
  }
  public function getAllSeverities()
  {
    return TICKET_SEVERITIES;
  }
  public function getAllStatus()
  {
    return TICKET_STATUS;
  }

  public function get($data)
  {
    return parent::getBy("*", $data);
  }

  public function getAllTickets()
  {
    return parent::getAll("*");
  }

  public function deleteById($tId)
  {
    $query = array('id' => $tId);
    return parent::deleteBy($query);
  }

  public function add_thread($data, $sendEmail = FALSE)
  {
    $res = $this->db->insert(TABLE_MESSAGES, $data);
    $info = parent::getBy(array('owner', 'ticket_no', 'subject'), array('ticket_no' => $data['ticket']));
    return $res;
  }

  //TODO: should this be in User_model? but this is Ticket specific only
  public function getEmailFromUsername($username)
  {
    if (!$this->checkIfEmail($username))
      return $username . '@' . CLIENT_DOMAIN;
    else return $username;
  }

  public function getUsernameFromEmail($email)
  {
    if (!$this->checkIfEmail($email)) {
      $split = explode('@', $email);
      $domain = $split[1];
      if ($domain == CLIENT_DOMAIN) return $split[0];
    }
    return $email;
  }

  public function sendUpdateEmail($users, $subject, $message)
  {
    $to_emails = array();
    foreach ($users as $user) {
      array_push($to_emails, $this->getEmailFromUsername($user));
    }
    return $this->Email->send($to_emails, CLIENT_FROM_EMAIL, $subject, $message . CLIENT_MAIL_FOOTER, CLIENT_REPLYTO_EMAIL);
  }


  // checks if string is email.
  function checkIfEmail($str)
  {
    if (filter_var($str, FILTER_VALIDATE_EMAIL))
      return TRUE;
    else
      return FALSE;
  }
}
