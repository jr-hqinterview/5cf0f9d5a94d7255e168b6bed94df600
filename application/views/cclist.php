<div class="row">
  <div class="col-md-12">
  <h3>Credit Card No Sample</h3>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Credit Card No Sample</h3>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <th>Credit card no</th>
            <th>Purposed card type</th>
          </thead>
          <tbody>
            <?php
            $out = "";
            foreach ($cc as $c) {
              $out .= "<tr>";
              $out .= "<td>".$c->card_number."</td>";
              $out .= "<td>".$c->cardType."</td>";
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
