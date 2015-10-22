<div class="row">
  <div class="col-md-12">

    <h3>Make a payment</h3>
    <?=$this->session->flashdata('msg');?>
    <?=validation_errors('<div class="alert alert-danger">','</div>');?>
    <?=form_open('', array('name'=>'frmPayment','id'=>'frmPayment'));?>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Your order</h3>
      </div>
      <div class="panel-body">

        <div id="gpAmt" class="form-group">
            <?=form_label('Price','amount',array('class'=>'control-label'));?>
            <span class="error"></span>
            <div class="input-group">
              <div class="input-group-addon">$</div>
              <?=form_input(array('name'=>'amount','id'=>'amount','class'=>'form-control','title'=>'Please type the amount in numeric','value'=>set_value('amount')));?>
              <div class="input-group-addon">.00</div>
            </div>
        </div>

        <div id="gpCur" class="form-group">

            <?=form_label('Currency','cur',array('class'=>'control-label'));?>
            <span class="error"></span>
            <?=form_dropdown('cur',$allowCur,'usd',array('id'=>'cur','class'=>'form-control'));?>
        </div>

        <div id="gpCustName" class="form-group">

            <?=form_label('Customer Full name','custName',array('class'=>'control-label'));?>
            <span class="error"></span>
            <?=form_input(array('name'=>'custName','id'=>'custName','class'=>'form-control','title'=>'Only accept A-Z a-z','value'=>set_value('custName')));?>
        </div>
      </div>
    </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Your credit card</h3>
      </div>
      <div class="panel-body">

        <div id="gpCcHolder" class="form-group">

          <?=form_label('Credit card holder name','ccHolder',array('class'=>'control-label'));?>
          <span class="error"></span>
          <?=form_input(array('name'=>'ccHolder','id'=>'ccHolder','class'=>'form-control','title'=>'Only accept A-Z a-z','value'=>set_value('ccHolder')));?>
        </div>

        <div id="gpCcNum" class="form-group">

          <?=form_label('Credit card number','ccNum',array('class'=>'control-label'));?>
          <span class="error"></span>
          <?=form_input(array('name'=>'ccNum','id'=>'ccNum','class'=>'form-control',  'title'=>'Only accept numeric','value'=>set_value('ccNum')));?>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div id="gpCcExpMM" class="form-group">

              <?=form_label('Credit card expiration (MM)','ccExpMM',array('class'=>'control-label'));?>
              <span class="error"></span>
              <?=form_input(array('name'=>'ccExpMM','id'=>'ccExpMM','class'=>'form-control','pattern'=>'[0][1-9]|[1][0-2]','title'=>'Only numeric, For example: Mar, please type in 03','value'=>set_value('ccExpMM')));?>
            </div>
          </div>
          <div class="col-md-6">
            <div id="gpCcExpYY" class="form-group">

              <?=form_label('Credit card expiration (YY)','ccExpYY',array('class'=>'control-label'));?>
              <span class="error"></span>
              <?=form_input(array('name'=>'ccExpYY','id'=>'ccExpYY','class'=>'form-control','pattern'=>'[1-9][0-9]','title'=>'Only numeric, For example: 2015, please type in 15','value'=>set_value('ccExpYY')));?>
            </div>
          </div>
        </div>

        <div id="gpCcCCV" class="form-group">

          <?=form_label('Credit card CCV','ccCCV',array('class'=>'control-label'));?>
          <span class="error"></span>
          <?=form_input(array('name'=>'ccCCV','id'=>'ccCCV','class'=>'form-control','pattern'=>'[0-9]{3,4}','title'=>'Only numeric','value'=>set_value('ccCCV')));?>
        </div>

      </div>
    </div>

    <div class="form-group">
      <button type="button" class="btn btn-primary" id="btnPay">Pay now</button>
    </div>

    <?=form_close();?>
  </div>

</div>
