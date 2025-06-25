<?php
$queryOrder = mysqli_query($config, "SELECT trans_order.*, customer.customer_name FROM trans_order LEFT JOIN customer ON trans_order.id_customer = customer.id ORDER BY id DESC");
$rowOrder = mysqli_fetch_all($queryOrder, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $now = date('Y-m-d H:i:s');
    mysqli_query($config, "UPDATE customer SET deleted_at = '$now' WHERE id='$id_user'");
    header("location:?page=order&hapus=berhasil");
}
?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Order</h5>
                    <div class="table-responsive">
                        <div class="mb-3" align="right">
                            <a href="?page=tambah-order" class="btn btn-primary">Add Order</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowOrder as $order): ?>
                                    <tr>
                                        <td><a href="?page=tambah-order&detail=<?php echo $order['id'] ?>"><?php echo $order['order_code'] ?></a></td>
                                        <td><?php echo $order['customer_name'] ?></td>
                                        <td><?php echo $order['order_date'] ?></td>
                                        <td><?php echo $order['order_status'] ?></td>
                                        <td>
                                            <a href="print.php?id=<?php echo $order['id'] ?>" class="btn btn-warning">Print</a>
                                            <a href="?page=order&delete=<?php echo $order['id'] ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>