<?PHP
require_once "constants.php";

class Ticket_model extends BaseMySQL_model
{

  public function __construct()
  {
    parent::__construct(TABLE_TICKETS);
    $this->load->model("core/Session_model", "Session");
    $this->load->model("user/User_model", "User");
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
    $info = getValuesOfKeys($data, array('owner', 'purpose', 'message', 'assign_to', 'assign_on', 'id_service', 'id_subservice', 'id_priority', 'data'));
    $attachments = $info['data'];
    $info['data'] = json_encode($info['data']);
    if (!$info['owner']) $info['owner'] = $this->Session->getLoggedDetails()['username'];
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

      parent::getBy(array('owner', 'ticket_no'), array('id' => $data['id']));
    } else $res = -1;

    return $res;
  }

  public function getServices()
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

  public function getPriority($idSubservice = null)
  {
    if ($idSubservice !== null) return $this->db->select('priority.id, priority.name')->where('subservices.id', $idSubservice)->join('priority', 'subservices.id_priority = priority.id')->get('subservices')->result_array();
    return $this->db->get('priority')->result_array();
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
    return $res;
  }

  /**
   * Function to get value from join ticket table with another table
   */
  public function getTableJoin($select = null, $where = null, $join = array(), $column = array(), $as = null, $array = false)
  {
    return parent::getTableJoin($select, $where, $join, $column, $as, $array);
  }

  /**
   * Function to generate datatable
   */
  public function generateDatatable($select = null, $where = null, $join = array(), $column = array(), $as = null)
  {
    return parent::generateDatatable($select, $where, $join, $column, $as);
  }
}
