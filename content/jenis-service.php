<?php
$queryCustomer = mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at IS NULL ORDER BY id DESC");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id_customer = $_GET['delete'];
    $now = date('Y-m-d H:i:s');
    mysqli_query($config, "UPDATE type_of_service SET deleted_at = '$now' WHERE id='$id_customer'");
    header("location:?page=customer&hapus=berhasil");
}
?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jenis Service</h5>
                    <div class="table-responsive">
                        <div class="mb-3" align="right">
                            <a href="?page=tambah-jenis-service" class="btn btn-primary">Add Jenis Service</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Price</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowCustomer as $index => $customer): ?>
                                    <tr>
                                        <td><?php echo $index += 1 ?></td>
                                        <td><?php echo $customer['service_name'] ?></td>
                                        <td><?php echo $customer['price'] ?></td>
                                        <td><?php echo $customer['description'] ?></td>
                                        <td>
                                            <a href="?page=tambah-jenis-service&edit=<?php echo $customer['id'] ?>" class="btn btn-warning">Edit</a>
                                            <a href="?page=jenis-service&delete=<?php echo $customer['id'] ?>" class="btn btn-danger">Delete</a>
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