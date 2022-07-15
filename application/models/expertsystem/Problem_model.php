<?php

class Problem_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('problem');
  }

  // public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  // {
  //   return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  // }
  public function get_problem_by_id($id)
  {
    return $this->db->where('id', $id)->get('problem')->row_array();
  }

  public function get_problem($id_subservice = null)
  {
    if ($id_subservice === null) return $this->db->get('problem')->result_array();
    // return $this->db->where('id_subservice', $id_subservice)->get('problem')->result_array();
  }

  public function delete_by_id($id_problem = null)
  {
    return $this->db->delete('problem', ['id' => $id_problem]);
  }

  public function update_problem($id, $data)
  {
    return $this->db->update('problem', $data, ['id' => $id]);
  }

  public function add_problem($data)
  {
    return $this->db->insert('problem', $data);
  }
}
