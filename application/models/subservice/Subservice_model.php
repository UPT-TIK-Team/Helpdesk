<?php

class Subservice_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('subservices');
    $this->load->model("core/Session_model", "Session");
  }
}
