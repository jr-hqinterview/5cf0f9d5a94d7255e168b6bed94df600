<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller{
  private $cfgPayment;

  public function __construct(){
    parent::__construct();
    $this->load->model('payment_model');
    $this->cfgPayment = $this->config->item('payment');
  }

  public function index(){

    $fv = $this->form_validation;

    //setup php form validation rules
    $fv->set_rules('amount','Price','required|numeric|callback_chkPrice', array('chkPrice'=>'The amount is not valid.'));
    $fv->set_rules('cur','Currency','required|alpha|callback_chkCurrency', array('chkCurrency'=>'Invalid Currency'));
    $fv->set_rules('custName','Customer Full name','required|alpha_numeric_spaces');
    $fv->set_rules('ccHolder','Credit card holder name','required|alpha_numeric_spaces');
    $fv->set_rules('ccNum','Credit card number','required|numeric|callback_chkCcNum',array('chkCcNum'=>'Credit card number is invalid'));
    $fv->set_rules('ccExpMM','Credit card expire month','required|in_list[01,02,03,04,05,06,07,08,09,10,11,12]',array('in_list'=>'Your credit card expire month is invalid.'));
    $fv->set_rules('ccExpYY','Credit card expire year','required|exact_length[2]|callback_chkExpYY',array('chkExpYY'=>'Your credit card expiration is invalid.'));
    $fv->set_rules('ccCCV','Credit Card CCV','required|min_length[3]|max_length[4]|numeric');

    //set error message
    $fv->set_message('required','{field} field must me fill.');
    $fv->set_message('numeric','{field} should not be an alpha.');
    $fv->set_message('alpha_numeric_spaces','{field} value can be combine with Alpha, Number & Space.');
    $fv->set_message('min_length','{field} length is shorter than {param}');
    $fv->set_message('max_length','{field} length is longer than {param}');
    $fv->set_message('exact_length','{field} length is not {param}');

    if ($this->form_validation->run() == FALSE){

      //data pass to view
      $data['allowCur'] = $this->cfgPayment['currecy'];

      //js form validation
      $data['js'] = "<script src='asset/js/frmPayment.min.js'></script>";

      //init view
      $this->_loadview('payment/index',$data);
    } else {
        $post = $this->input->post();
        $ccType = $this->session->flashdata('ccType');
        $gateway = $this->payment_model->assign_gateway($ccType,$post['cur']);

        //get allow gateway from config
        $allowGateway = $this->cfgPayment['gateway'];

        if(in_array($gateway,$allowGateway)){
          $this->session->set_flashdata('paymentDetail',array('postVal'=>$post,'ccType'=>$ccType,'gateway'=>$gateway));
          redirect('payment/transactionProgressing');
        } else {
          $this->session->set_flashdata('errMsg',"American Express Credit card is possible to use only for USD");
          $this->session->set_flashdata('allow',true);
          redirect('payment/error');

        }
    }
  }

  public function chkPrice($str){
    return $str <= 0 ? false : true;
  }

  public function chkCurrency($str){
    $payment = $this->config->item('payment');
    $allowCur = $payment['currecy'];
    $curVal = array();
    foreach ($allowCur as $key => $value) {
      $curVal[] = $key;
    }
    if(in_array($str,$curVal)){
      return true;
    } else {
      return false;
    }
  }

  public function chkCcNum($str){
    $ccType = $this->payment_model->cc_identify($str);
    $this->session->set_flashdata('ccType',$ccType);
    return $ccType != "400" ? true : false;
  }

  public function chkExpYY($str){
    $month = $this->input->post('ccExpMM');
    $year = $str;

    if($year < date('y') || $year > date('y')+10){
      return false;
    }
    if($year == date("y") && $month < date('m')){
      return false;
    }
    return true;
  }

  public function transactionProgressing(){
    echo "<h2>Transaction Processing, Please wait. Dont click refresh or back</h2>";
    $paymentDetail = $this->session->flashdata('paymentDetail');
    $trans = $this->payment_model->startTransaction($paymentDetail);
    $this->session->set_flashdata('allow',true);
    $this->session->set_flashdata('transResult',$trans);
    redirect('payment/result');
  }

  public function result(){
    $triger = $this->session->flashdata('allow');
    if(!$triger){
      redirect('');
    }
    $data['detail'] = $this->session->flashdata('transResult');
    $this->_loadview('payment/result',$data);
  }
}
?>
