<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
  public function __construct(){
    parent::__construct();
  }

  public function _loadview($view, $data = array()){
    $this->load->view('/templates/header',$data);
    $this->load->view($view,$data);
    $this->load->view('/templates/footer',$data);
  }
}
