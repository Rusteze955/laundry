<?php
if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    $query = mysqli_query($config, "SELECT * FROM trans_order WHERE id='$edit'");
    $row = mysqli_fetch_assoc($query);

    if (isset($_POST['save'])) {
        $name = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        mysqli_query($config, "UPDATE customer SET customer_name='$name', phone='$phone', address='$address' WHERE id='$edit'");
        header("location:?page=customer&ubah=berhasil");
    }
} else {
    if (isset($_POST['save'])) {
        $name = $_POST['customer_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        mysqli_query($config, "INSERT INTO customer (customer_name, phone, address) VALUES ('$name', '$phone', '$address')");
        header("location:?page=customer&tambah=berhasil");
    }
}

$queryOrder = mysqli_query($config, "SELECT * FROM trans_order ORDER BY id DESC");
if (mysqli_num_rows($queryOrder) == 0) {
    $orderCode = "#1";
} else {
    $rowOrder = mysqli_fetch_assoc($queryOrder);
    $orderCode = "#" . $rowOrder['id'] + 1;
}

$queryCustomer = mysqli_query($config, "SELECT * FROM customer ORDER BY id DESC");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Order</h5>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Code</label>
                            <input readonly name="order_code" type="text" class="form-control" value="<?php echo $orderCode ?>">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <select name="customer_name" id="" class="form-control" required>
                                <option value="">Select Customer</option>
                                <?php foreach ($rowCustomer as $customer): ?>
                                    <option <?php echo isset($_GET['edit']) ? ($customer['id'] == $row['id_customer'] ? 'selected' : '') : '' ?> value="<?php echo $customer['id'] ?>"><?php echo $customer['customer_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Order Date</label>
                            <input name="order_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_date'] : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Order Status</label>
                            <select name="order_status" id="" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="0">Process</option>
                                <option value="1">Pick Up</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button name="save" type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>