<?php
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

$queryTransOrderDetail = mysqli_query($config, "SELECT trans_order_detail.*, type_of_service.*, trans_order.order_date FROM trans_order_detail LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id LEFT JOIN trans_order ON trans_order.id = trans_order_detail.id_order WHERE order_date BETWEEN '$date' AND '$end_date'");
$rowTransOrderDetail = mysqli_fetch_all($queryTransOrderDetail, MYSQLI_ASSOC);

?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Report</h5>
                    <form action="" method="post">
                        <label for="">Start Date</label>
                        <input type="date" name="date">
                        <label for="">End Date</label>
                        <input type="date" name="end_date">
                        <button type="submit" name="filter" class="btn btn-secondary mb-2">Filter</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Service Name</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowTransOrderDetail as $index => $data): ?>
                                    <tr>
                                        <td><?php echo $index += 1 ?></td>
                                        <td><?php echo $data['service_name'] ?></td>
                                        <td><?php echo $data['order_date'] ?></td>
                                        <td><?php echo $data['qty'] ?></td>
                                        <td><?php echo $data['price'] ?></td>
                                        <td><?php echo $data['subtotal'] ?></td>
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