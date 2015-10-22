<div class="row">
  <div class="col-md-12">
    <?php if($detail['status'] == "200"){ ?>
    <div class="alert alert-success">
    Transaction have been completed.
    </div>

    <h3>Transaction Detail</h3>
    <p>Transaction Time: <?=$detail['detail']['update_time'];?> (GMT)</p>
    <p>Total Amount: <?=$detail['detail']['amount'];?></p>
    <p>Currency: <?=$detail['detail']['currency'];?></p>
    <p>Ref. No: <?=$detail['detail']['sales_id'];?></p>
    <p>Payment Gateway: <?=$detail['detail']['gateway'];?></p>

    <?php } else { ?>
    <div class="alert alert-danger">
    Transaction can not be process.<br/>Message: <?=$detail['errMsg'];?>
    </div>
    <?php } ?>
    <?=anchor('','Back to form',array('class'=>'btn btn-primary'));?>
    <p></p>
  </div>

</div>
