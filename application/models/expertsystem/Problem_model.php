<?php

class Problem_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('problem');
  }

  public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  {
    return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  }

  public function get_problem($id_subservice)
  {
    return $this->db->where('id_subservice', $id_subservice)->get('problem')->result_array();
  }
}
