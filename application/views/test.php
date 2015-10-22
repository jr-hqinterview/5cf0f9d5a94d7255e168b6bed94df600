<div class="row">
  <div class="col-md-12">
      <h3>Payment Model Test</h3>
      <?php
      if($result != NULL){
        echo $result;
      } ?>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Test credit card identitfy</h3>
      </div>
      <div class="panel-body">
        <?=form_open('test/cc_identify');?>
        <div class="form-group">
          <label>Credit Card Number</label>
          <input class="form-control" type="text" name="ccno" />
        </div>
        <div class="form-group">
          <label>Expected Answer (visa, master, amex, jcb, discover, diners, error)</label>
          <input class="form-control" type="text" name="expectans" />
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Test</button>
        </div>
        <?=form_close();?>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Test assgin gateway</h3>
      </div>
      <div class="panel-body">
        <?=form_open('test/assign_gateway');?>
        <div class="form-group">
          <label>Credit Card Type</label>
          <input class="form-control" type="text" name="ccType" />
        </div>
        <div class="form-group">
          <label>Currency (USD,EUR,AUD,HKG,SGD,THB)</label>
          <input class="form-control" type="text" name="cur" />
        </div>
        <div class="form-group">
          <label>Expected Answer (paypal,briantree,400)</label>
          <input class="form-control" type="text" name="expectans" />
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Test</button>
        </div>
        <?=form_close();?>
      </div>
    </div>
  </div>

</div>
