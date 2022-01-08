<?php

class Service_model extends BaseMySQL_model
{
  public function __construct()
  {
    parent::__construct('services');
    $this->load->model("core/Session_model", "Session");
  }
}
