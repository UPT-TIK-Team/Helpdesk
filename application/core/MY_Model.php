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
  public function getBy($select = null, $where = null, $limit = null)
  {
    if ($select == null) $select = "*";
    $res = $this->db->select($select)->where($where);
    if ($limit) $res->limit($limit);
    return $res->order_by('id', 'desc')->get($this->table)->result_array();
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
    $data = $this->db->select($select)->select("$as, $this->table.id as id_ticket");
    if ($where != null) $data->where($where);
    foreach ($join as $i => $j) {
      $data->join($j, "$this->table.$column[$i]=$j.id");
    }
    $data = $data->get($this->table);
    if ($where == null || ($where != null && $array == true)) {
      $data = $data->result_array();
    } else {
      $data = $data->row_array();
    }
    return $data;
  }

  /**
   * Handle for generateDatatable
   */
  public function generateDatatable($select = null, $where = null, $join = array(), $column = array(), $as = null, $addcolumn = array())
  {
    if ($select == null) $select = "$this->table.*";
    $this->datatables->select($select);
    if ($as != null) $this->datatables->select($as);
    $this->datatables->from($this->table);
    if (!empty($join)) {
      foreach ($join as $i => $j) {
        $this->datatables->join($j, "$this->table.$column[$i]=$j.id");
      }
    }
    if (!empty($addcolumn)) {
      $this->datatables->add_column('action', '<a href="' . $addcolumn[1] . '/$1" class="badge badge-primary">View</a>',  $addcolumn[2]);
    }

    if (empty($where)) {
      return $this->datatables->generate();
    } else if (empty($where[1]) && empty($where[2])) {
      $this->datatables->where($where);
    } else if ($where[1] == 'NULL' && $where[2] == 'FALSE') {
      $this->datatables->where($where[0], NULL, FALSE);
    }
    return $this->datatables->generate();
  }
}


class_alias('BaseMySQL_model', 'BaseSetters_model');
