<?php
if (isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    $query = mysqli_query($config, "SELECT * FROM trans_order WHERE id='$edit'");
    $row = mysqli_fetch_assoc($query);

    if (isset($_POST['save'])) {
        $id_customer = $_POST['id_customer'];
        $order_code = $_POST['order_code'];
        $order_status = $_POST['order_status'];
        $order_date = $_POST['order_date'];

        mysqli_query($config, "UPDATE trans_order SET id_customer='$id_customer', order_code='$order_code', order_status='$order_status', order_date='$order_date' WHERE id='$edit'");
        header("location:?page=order&ubah=berhasil");
    }
} else {
    if (isset($_POST['save'])) {
        $id_customer = $_POST['id_customer'];
        $order_code = $_POST['order_code'];
        $order_status = $_POST['order_status'];
        $order_date = $_POST['order_date'];

        mysqli_query($config, "INSERT INTO trans_order (id_customer, order_code, order_status, order_date) VALUES ('$id_customer', '$order_code', '$order_status', '$order_date')");
        header("location:?page=order&tambah=berhasil");
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

$queryService = mysqli_query($config, "SELECT * FROM type_of_service ORDER BY id DESC");
$rowService = mysqli_fetch_all($queryService, MYSQLI_ASSOC);

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
                                    <select name="id_customer" id="" class="form-control">
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
                                    <th>Service</th>
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
//ambil data service di php
const services = <?= json_encode($rowService) ?>;

//ambil input si addrow 

function numberRow() {
    const rows = document.querySelectorAll('#myTable tbody tr');
    rows.forEach((row, index) => {
        const numberCell = row.querySelector('.row-number');
        if (numberCell) {
            numberCell.textContent = index + 1;
        }
    });
}

document.getElementById('addRow').addEventListener('click', function() {
    const tbody = document.querySelector('#myTable tbody');
    const row = document.createElement('tr');

    let serviceOptions = '<option value="">-- Pilih Service --</option>';
    services.forEach(service => {
        serviceOptions += `<option value="${service.id}" data-price="${service.price}">
                ${service.service_name}
            </option>`;
    });

    row.innerHTML = `
        <td class="row-number"></td>
        <td>
            <select name="id_service[]" class="form-control service-select" required>
                ${serviceOptions}
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1"></td>
        <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
        <td><input type="number" name="total[]" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">X</button></td>
    `;

    tbody.appendChild(row);
    newRow(row); // <-- Kirim baris yang baru ditambahkan
    numberRow(row); //nambah si No 
});

function hitungTotal() {
    const totalFields = document.querySelectorAll('.total');
    let grand = 0;
    totalFields.forEach(field => {
        grand += parseFloat(field.value || 0);
    });
    document.getElementById('grandTotal').innerText = grand.toLocaleString();
}

function newRow(row) {
    const select = row.querySelector('.service-select');
    const qty = row.querySelector('.qty');
    const harga = row.querySelector('.harga');
    const total = row.querySelector('.total');
    const deleteBtn = row.querySelector('.deleteRow');


    select.addEventListener('change', function() {
        const price = this.options[this.selectedIndex].getAttribute('data-price');
        harga.value = price || 0;
        total.value = (qty.value || 0) * (price || 0)
        y
        hitungTotal();
    });

    qty.addEventListener('input', function() {
        const price = parseFloat(harga.value) || 0;
        const quantity = parseFloat(qty.value) || 0;
        total.value = quantity * price;
        hitungTotal();
    });

    deleteBtn.addEventListener('click', function() {
        row.remove();
        hitungTotal();
        numberRow(); // hapus si no yang ditambah lewat numberRow()
    });;
}
</script>