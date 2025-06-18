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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Code</label>
                                    <input readonly name="order_code" type="text" class="form-control" value="<?php echo $orderCode ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <select name="customer_name" id="" class="form-control">
                                        <option value="">Select Customer</option>
                                        <?php foreach ($rowCustomer as $customer): ?>
                                            <option <?php echo isset($_GET['edit']) ? ($customer['id'] == $row['id_customer'] ? 'selected' : '') : '' ?> value="<?php echo $customer['id'] ?>"><?php echo $customer['customer_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Order Status</label>
                                    <select name="order_status" id="" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="0">Process</option>
                                        <option value="1">Pick Up</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Order Date</label>
                                    <input name="order_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_date'] : '' ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">End Date</label>
                                    <input name="order_date" type="date" class="form-control" value="<?php echo isset($_GET['edit']) ? $row['order_date'] : '' ?>">
                                </div>
                            </div>
                        </div>
                        <div align="right" class="mb-3">
                            <button type="button" class="btn btn-primary addRow" id="addRow">Add Row</button>
                        </div>
                        <table class="table" id="myTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="mb-3">
                            <button name="save" type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // var, let, const
    // var : ketika nilainya tidak ada, maka tidak ada error
    // let : harus mempunyai nilai
    // const :isi nya tidak boleh berubah
    // const button = document.getElementById('addRow');
    // const button = document.getElementsByClassName('addRow');
    const button = document.querySelector('.addRow');
    const tbody = document.querySelector('#myTable tbody');
    // button.textContent = "duar";
    // button.style.color = "red";

    let no = 1;
    button.addEventListener("click", function() {
        // alert('Duar');
        const tr = document.createElement('tr'); //<tr></tr>
        tr.innerHTML = `
        <td>${no}</td>
        <td><input type='hidden' name='id_product[]'></td>
        <td><input type='number' name='qty[]' value='0'></td>
        <td><input type='hidden' name='total[]'></td>
        <td><button class='btn btn-danger btn-sm removeRow' type='button'>Delete</button></td>`;

        tbody.appendChild(tr);
        no++;
    });

    tbody.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeRow')) {
            e.target.closest("tr").remove();
        }

        updateNumber()

    });

    function updateNumber() {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(function(row, index) {
            row.cells[0].textContent = index + 1;
        });

        no = rows.length + 1;
    }
</script>