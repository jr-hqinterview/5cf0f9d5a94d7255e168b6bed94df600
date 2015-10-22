<div class="row">
  <div class="col-md-12">
  <h3>Payment History</h3>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">History</h3>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <th>Transaction ID</th>
            <th>Sales ID</th>
            <th>Create Time</th>
            <th>Update Time</th>
            <th>Currency</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Gateway</th>
          </thead>
          <tbody>
            <?php
            $out = "";
            foreach ($items as $i) {
              $out .= "<tr>";
              $out .= "<td>".$i->id."</td>";
              $out .= "<td>".$i->sales_id."</td>";
              $out .= "<td>".$i->create_time."</td>";
              $out .= "<td>".$i->update_time."</td>";
              $out .= "<td>".$i->currency."</td>";
              $out .= "<td>".$i->amount."</td>";
              $out .= "<td>".$i->gateway."</td>";
              $out .= "<td>".$i->state."</td>";
              $out .= "</tr>";
            }
            echo $out;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  </div>

</div>
