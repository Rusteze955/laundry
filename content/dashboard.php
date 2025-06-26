<?php
$queryUser = mysqli_query($config, "SELECT * FROM user");
$countUser = mysqli_num_rows($queryUser);

$queryCustomer = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL");
$countCustomer = mysqli_num_rows($queryCustomer);

$queryService = mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at IS NULL");
$countService = mysqli_num_rows($queryService);

$id = $_SESSION['ID_USER'];
$queryLogin = mysqli_query($config, "SELECT user.*, level.level_name FROM user LEFT JOIN level ON user.id_level = level.id WHERE user.id = '$id'");
$rowLogin = mysqli_fetch_assoc($queryLogin);

$queryOrder = mysqli_query($config, "SELECT c.customer_name, o.* FROM trans_order o LEFT JOIN customer c ON o.id_customer = c.id ORDER BY total DESC LIMIT 7");
$rowOrder = mysqli_fetch_all($queryOrder, MYSQLI_ASSOC);
?>

<div class="container-fluid flex-grow-1 container-p-y">
  <!-- Layout Demo -->
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title" align="center">Dashboard</h3>
          <div class="row mb-3">
            <div class="col-sm-4 text-center">
              <div class="mb-3">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title" align="center">Account Login</h5>
                    <div class="mb-3">
                      <img src="img/luffy.jpeg" alt="alt" width="50%" />
                    </div>
                    <div style="text-align: justify">
                      Name : <?php echo $rowLogin['name']; ?><br>
                      Level : <?php echo $rowLogin['level_name']; ?><br>
                      Email : <?php echo $rowLogin['email']; ?><br>
                      Login Date : <?php echo date('d F Y'); ?><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-8">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($rowOrder as $key => $data) { ?>
                      <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $data['customer_name']; ?></td>
                        <td><?php echo $data['order_date']; ?></td>
                        <td><?php echo $data['order_status'] == 1 ? 'Pickup' : 'Process'; ?></td>
                        <td><?php echo $data['total']; ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title" align="center">Data Customer</h5>
                  <h1 align="center"><?php echo $countCustomer; ?></h1>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title" align="center">Data Service</h5>
                  <h1 align="center"><?php echo $countService; ?></h1>
                </div>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title" align="center">Data User</h5>
                  <h1 align="center"><?php echo $countUser; ?></h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Layout Demo -->
</div>