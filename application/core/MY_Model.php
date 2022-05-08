<?php

class MY_Model extends CI_Model
{

  protected $CI;

  function __construct()
  {
    parent::__construct();
  }

  protected function loadCI()
  {
    return $this->CI = &get_instance();
  }
}

/**
 * Class BaseMySQL
 * Base class to offer basic setters for master
 */
class BaseMySQL_model extends MY_Model
{
  public function __construct($table)
  {
    parent::__construct();
    $this->table = $table;
  }

  /**
   * Add item and return ID.
   * @param $data
   * @return mixed
   */
  public function add($data)
  {

    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }

  /**
   * Get By some conditions.
   * @param string|array $select
   * @param $where
   * @return mixed
   */
  public function getBy($select = null, $where = null, $limit = null, $array = false)
  {
    if ($select == null) $select = "*";
    $this->db->select($select);
    if ($where) $this->db->where($where);
    if ($limit) $this->db->limit($limit);
    $res = $this->db->order_by('id', 'desc')->get($this->table);
    if ($array === false) return $res->row_array();
    return $res->result_array();
  }

  /**
   * Get By OR
   * @param string|array $select
   * @param $where
   * @return mixed
   */
  public function getByOR($select = null, $where = null)
  {
    if ($select == null) $select = "*";
    return $this->db->select($select)->or_where($where)->get($this->table)->result_array();
  }


  /**
   * Get By ID
   * @param $id
   * @param null $fields
   * @return mixed
   */
  public function getByID($id, $fields = null)
  {
    return $this->getOneItem($this->getBy($fields, array('id' => $id)));
  }

  /**
   * @param $select
   * @return mixed
   */
  public function getAll($select = null)
  {
    if ($select == null) $select = "*";
    $query = $this->db->select($select)->get($this->table);
    return $query->result_array();
  }


  /**
   * Set status of specific element.
   * @param $id
   * @param int $status
   * @return mixed
   */
  public function setStatus($id, $status = 0)
  {
    $check = $this->db->set(array('status' => $status))->where(array('id' => $id))->update($this->table);
    return $check;
  }


  /**
   * Set specific field by ID
   * @param $id
   * @param array $fields
   * @return mixed
   */
  public function setByID($id, $fields = array())
  {
    $check = $this->db->set($fields)->where(array('id' => $id))->update($this->table);
    return $check;
  }

  /**
   * Set specific field by ID
   * @param $where
   * @return mixed
   */
  public function deleteBy($where = array())
  {
    $result = $this->db->where($where)->delete($this->table);
    return $result;
  }

  /**
   * Remove an item by id.
   * @param $id
   * @return mixed
   */
  public function deleteById($id)
  {
    $query = array('id' => $id);
    $result = $this->deleteBy($query);
    return $result;
  }

  /**
   * Returns first or last item from array, if nothing then null.
   * @param $res
   * @param bool $last true to return last item.
   * @return |null
   */
  static function getOneItem($res, $last = false)
  {
    if (!is_array($res) || count($res) == 0)
      return null;

    //if last is set, get last item
    return $res[$last ? count($res) - 1 : 0];
  }

  public function getTableName()
  {
    return $this->table;
  }

  public function getDB()
  {
    return $this->db;
  }

  /**
   * Handle Table Join
   */
  public function getTableJoin($select = null, $where = null, $join = array(), $column = array(), $as = null, $array = false)
  {
    if ($select == null) $select = "$this->table.*";
    $this->db->select($select);
    if ($as) $this->db->select($as);
    if ($where) $this->db->where($where);
    foreach ($join as $i => $j) {
      $this->db->join($j, "$this->table.$column[$i]=$j.id");
    }
    $data = $this->db->get($this->table);
    if ($where == null || ($where && $array == true)) {
      return $data->result_array();
    } else {
      return $data->row_array();
    }
  }

  /**
   * Handle for generateDatatable
   * @return Object datatables
   */
  public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null)
  {
    if ($select == null) $select = "$this->table.*";
    $this->datatables->select($select)->from($this->table);

    // Handle if 'join' parameter is exist, parameters 'join' and 'column' must be connect and same index
    if (!empty($join)) {
      foreach ($join as $i => $j) {
        $this->datatables->join($j, "$this->table.$column[$i]=$j.id", 'left');
      }
    }

    // Handle if 'as' parameter is exist
    if ($as) $this->datatables->select($as);

    // If 'where' parameters is empty just return datatables object
    if (empty($where)) return $this->datatables->generate();

    // Get key from first 'where' parameters
    $key = array_keys($where)[0];

    // Get value from first 'where' parameters
    $val = array_values($where)[0];

    // Check for 'where' parameters value and send appropriate response
    if ($val === '!=0') {
      $this->datatables->where($key . '!=', $val);
    } else {
      $this->datatables->where($this->table . '.' . $key, $val);
    }
    return $this->datatables->generate();
  }
}


class_alias('BaseMySQL_model', 'BaseSetters_model');
