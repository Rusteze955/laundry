<?php 
$queryCustomer = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL ORDER BY id DESC");
$rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

if(isset($_GET['delete'])){
    $id_customer = $_GET['delete'];
    $now = date('Y-m-d H:i:s');
    mysqli_query($config, "UPDATE customer SET deleted_at = '$now' WHERE id='$id_customer'");
    header("location:?page=customer&hapus=berhasil");
}
?>
<section class="section">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Data Customer</h5>
                <div class="table-responsive">
                    <div class="mb-3" align="right">
                        <a href="?page=tambah-customer" class="btn btn-primary">Add Customer</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rowCustomer as $index => $customer): ?> 
                            <tr>
                                <td><?php echo $index +=1 ?></td>
                                <td><?php echo $customer['customer_name'] ?></td>
                                <td><?php echo $customer['phone'] ?></td>
                                <td><?php echo $customer['address'] ?></td>
                                <td>
                                    <a href="?page=tambah-order&id_customer=<?php echo $customer ['id'] ?>" class="btn btn-secondary">Order</a>
                                    <a href="?page=tambah-customer&edit=<?php echo $customer ['id'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="?page=customer&delete=<?php echo $customer ['id'] ?>" class="btn btn-danger">Delete</a>
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