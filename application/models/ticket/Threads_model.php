<?php
require_once __DIR__ . "/constants.php";

class Threads_model extends BaseMySQL_model
{
  function __construct()
  {
    parent::__construct(TABLE_TICKETS);
  }

  public function get_ticket_threads($ticket_id)
  {
    return $this->db->select(
      TABLE_MESSAGES . '.id as id, '
        . TABLE_MESSAGES . '.ticket as ticket, '
        . TABLE_MESSAGES . '.message as message, '
        . TABLE_MESSAGES . '.created as created, '
        . 'user.name as user_name, '
    )
      ->where(TABLE_MESSAGES . '.ticket', $ticket_id)
      ->join(TABLE_USERS . ' as user', 'user.id = ' . TABLE_MESSAGES . '.user', 'left')
      ->order_by(TABLE_MESSAGES . '.id', 'desc')
      ->get(TABLE_MESSAGES)->result_array();
  }

  // generic function to list ticket by where condition => $where is array;
  public function get_ticket_where($where)
  {
    return $this->db->where($where)
      ->get(TABLE_TICKETS)->result_array();
  }

  public function get_ticket_where_limit($where, $limit)
  {
    return $this->db->where($where)->limit($limit)->order_by('id', 'desc')->get(TABLE_TICKETS)->result_array();
  }

  public function close_ticket($ticket)
  {
    $update = [
      'status' => TICKET_STATUS_CLOSED,
      'closed' => time()
    ];
    return $this->db->where('ticket_no', $ticket)->update(TABLE_TICKETS, $update);
  }

  public function update_ticket($where, $update)
  {
    return $this->db->where($where)->update(TABLE_TICKETS, $update);
  }

  public function add_thread($array)
  {
    return $this->db->insert(TABLE_MESSAGES, $array);
  }

  /**
   * Function for handle get ticket on database 
   * @param Bool $array set to true because it will loop through view pages
   */
  public function getBy($select = null, $where = null, $limit = null, $array = true)
  {
    return parent::getBy($select, $where, $limit, $array);
  }
}
