<?php

class Rules_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('rule');
  }

  // public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  // {
  //   return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  // }

  public function get_rule_by_id($id)
  {
    return $this->db->select('problem.id as id_problem, problem.name as name_problem, symptom.id as id_symptom, symptom.name as name_symptom, mb, md')->where('rule.id', $id)->join('problem', 'rule.id_problem=problem.id')->join('symptom', 'rule.id_symptom=symptom.id')->get('rule')->row_array();
  }

  public function add_rule($data)
  {
    return $this->db->insert('rule', $data);
  }

  public function delete_by_id($id = null)
  {
    return $this->db->delete('rule', ['id' => $id]);
  }
}
