<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends MY_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->library('unit_test');
    $this->load->model('payment_model');
  }

  public function index(){
      $data['result'] = $this->session->flashdata('result');
      $this->_loadview('test',$data);
  }

  public function cc_identify(){
    $ccno = $this->input->post('ccno');
    $ans = $this->input->post('expectans');
    $test = $this->payment_model->cc_identify($ccno);
    $this->unit->run($test,$ans, 'Credit Card Identifiy Test');
    $report = $this->unit->result();
    $report = $report[0];

    $result = '
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Result: '.$report['Test Name'].'</h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>Test Credit Card Number</td>
                <td>'.$ccno.'</td>
              </tr>
              <tr>
                <td>Test Answer and datatype</td>
                <td>'.$test."(".$report['Test Datatype'].")".'</td>
              </tr>
              <tr>
                <td>Expected Answer and datatype</td>
                <td>'.$ans."(".$report['Expected Datatype'].")".'</td>
              </tr>
              <tr>
                <td>Result</td>
                <td><b>'.$report['Result'].'</b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    ';

    $this->session->set_flashdata('result', $result);
    redirect('test');
  }

  public function assign_gateway(){
    $ccType = $this->input->post('ccType');
    $cur = $this->input->post('cur');
    $expans = $this->input->post('expectans');
    $test = $this->payment_model->assign_gateway(strtolower($ccType),strtolower($cur));
    $this->unit->run($test,$expans,'Assign Payment Gateway Test');
    $report = $this->unit->result();
    $report = $report[0];

    $result = '
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Result: '.$report['Test Name'].'</h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped">
            <tbody>
              <tr>
                <td>Credit Card Type</td>
                <td>'.$ccType.'</td>
              </tr>
              <tr>
                <td>Currency</td>
                <td>'.$cur.'</td>
              </tr>
              <tr>
                <td>Test Answer and datatype</td>
                <td>'.$test."(".$report['Test Datatype'].")".'</td>
              </tr>
              <tr>
                <td>Expected Answer and datatype</td>
                <td>'.$expans."(".$report['Expected Datatype'].")".'</td>
              </tr>
              <tr>
                <td>Result</td>
                <td><b>'.$report['Result'].'</b></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    ';

    $this->session->set_flashdata('result', $result);
    redirect('test');

  }

  public function ccsample(){
      $data['cc'] = $this->db->select('card_number,cardType')->from('creditCard')->get()->result();
      $this->_loadview('cclist',$data);
  }

  public function history(){
      $data['items'] = $this->db->select('*')->from('transaction')->get()->result();
      $this->_loadview('paymentHistory',$data);
  }

  public function question(){
    $data['ans'] = $this->db->select('value')->from('stuff')->get()->result();
    $this->_loadview('answer',$data);
  }

}
?>
