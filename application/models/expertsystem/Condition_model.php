<?php

class Condition_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('condition');
  }

  public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  {
    return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  }

  public function get_condition($id = null)
  {
    // Check $id value
    if ($id !== null) return $this->db->where('id', $id)->get('condition')->result_array();
    return $this->db->get('condition')->result_array();
  }
}
