<?php

class Symptom_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('symptom');
  }

  public function generateDatatable($select = null, $where = array(), $join = array(), $column = array(), $as = null, $addcolumn = array())
  {
    return parent::generateDatatable($select, $where, $join, $column, $as, $addcolumn);
  }

  public function get_symptom($id_subservice)
  {
    if (!$id_subservice) return $this->db->get('symptom')->result_array();
    return $this->db->where('id_subservice', $id_subservice)->get('symptom')->result_array();
  }

  public function add_symptom($data)
  {
    return $this->db->insert('symptom', $data);
  }

  public function get_symptom_by_id($id)
  {
    return $this->db->select('symptom.name as name_symptom, subservices.id as id_subservice, subservices.name as name_subservice')->where('symptom.id', $id)->join('subservices', 'symptom.id_subservice=subservices.id')->get('symptom')->row_array();
  }

  public function delete_by_id($id = null)
  {
    return $this->db->delete('symptom', ['id' => $id]);
  }
}
