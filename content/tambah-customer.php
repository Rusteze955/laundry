<?php
if (strtolower($rowLevel['level_name']) == 'leader') {
    header("location:home.php?access=denied");
    exit;
}
if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    $query = mysqli_query($config, "SELECT * FROM customer WHERE id='$edit'");
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
?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Customer</h5>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama</label>
                            <input name="customer_name" type="text" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['customer_name'] : '' ?>" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Telepon</label>
                            <input name="phone" type="text" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['phone'] : '' ?>" placeholder="Enter your phone number" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Alamat</label>
                            <textarea name="address" id="" cols="30" rows="10" class="form-control" required><?php echo isset($_GET['edit']) ? $row['address'] : '' ?></textarea>
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