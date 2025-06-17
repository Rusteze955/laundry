<?php
$queryUser = mysqli_query($config, "SELECT * FROM user ORDER BY id DESC");
$rowUser = mysqli_fetch_all($queryUser, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $now = date('Y-m-d H:i:s');
    mysqli_query($config, "UPDATE customer SET deleted_at = '$now' WHERE id='$id_user'");
    header("location:?page=customer&hapus=berhasil");
}
?>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data User</h5>
                    <div class="table-responsive">
                        <div class="mb-3" align="right">
                            <a href="?page=tambah-user" class="btn btn-primary">Add User</a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rowUser as $index => $user): ?>
                                    <tr>
                                        <td><?php echo $index += 1 ?></td>
                                        <td><?php echo $user['name'] ?></td>
                                        <td><?php echo $user['email'] ?></td>
                                        <td>
                                            <a href="?page=tambah-user&edit=<?php echo $user['id'] ?>" class="btn btn-warning">Edit</a>
                                            <a href="?page=user&delete=<?php echo $user['id'] ?>" class="btn btn-danger">Delete</a>
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