<?php
if (strtolower($rowLevel['level_name']) == 'operator') {
    header("location:home.php?access=denied");
    exit;
}
$query = mysqli_query($config, "SELECT * FROM trans_order ORDER BY order_date ASC");
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
$max = mysqli_num_rows($query);

$minDate = $row[0]['order_date'];
$maxDate = $row[$max - 1]['order_date'];


if (isset($_POST['filter'])) {
    $date = $_POST['date'];
    $end_date = $_POST['end_date'];
} else {
    $date = $minDate;
    $end_date = $maxDate;
}

$q = mysqli_query($config, "SELECT c.customer_name, o.order_date, s.service_name, od.qty, s.price, od.subtotal
    FROM trans_order_detail od
    LEFT JOIN type_of_service s ON od.id_service = s.id
    LEFT JOIN trans_order o ON od.id_order = o.id
    LEFT JOIN customer c ON o.id_customer = c.id
    WHERE o.order_date BETWEEN '$date' AND '$end_date'
    ORDER BY od.id, o.total DESC
    ");

$r = mysqli_fetch_all($q, MYSQLI_ASSOC);

// $queryTransOrderDetail = mysqli_query($config, "SELECT trans_order_detail.*, type_of_service.*, trans_order.order_date FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order WHERE (trans_order.deleted_at IS NULL) AND (order_date BETWEEN '$date' AND '$end_date')");
// $rowTransOrderDetail = mysqli_fetch_all($queryTransOrderDetail, MYSQLI_ASSOC);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Report Detail Transaction Order</h5>
                <div class="table-responsive">
                    <div class="mb-3">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="" class="form-label">Date Start</label>
                                    <input type="date" name="date" class="form-control" value="<?php echo $start; ?>" required>
                                </div>
                                <div class="col-sm-3">
                                    <label for="" class="form-label">Date End</label>
                                    <input type="date" name="end_date" class="form-control" value="<?php echo $end; ?>" required>
                                </div>
                                <div class="col-sm-3 mt-8">
                                    <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-datatable pt-0">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Service</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($r as $row) : ?>
                                    <tr>
                                        <td><?php echo $row['customer_name']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td><?php echo $row['service_name']; ?></td>
                                        <td><?php echo $row['qty'] / 1000; ?></td>
                                        <td><?php echo $row['price']; ?></td>
                                        <td><?php echo $row['subtotal']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>